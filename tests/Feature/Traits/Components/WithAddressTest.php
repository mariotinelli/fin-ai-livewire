<?php

declare(strict_types = 1);

use App\Enums\Toast;
use App\Models\Address;
use App\Models\City;
use App\Models\State;
use App\Traits\Components\WithAddress;
use App\Traits\Components\WithToast;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Livewire;

beforeEach(function (): void {
    Http::preventStrayRequests();
});

class AddressTestComponent extends Component
{
    use WithAddress;
    use WithToast;

    public function render(): string
    {
        return '<div></div>';
    }
}

function addressComponent(): AddressTestComponent
{
    return new AddressTestComponent();
}

it('validates postal code length without requesting invalid inputs', function (?string $cep, bool $valid): void {
    expect(addressComponent()->postalCodeIsValid($cep))->toBe($valid);
})->with([[null, false], ['', false], ['0', false], ['123', false], ['123456789', false], ['13000-000', true], [' 13.000-000 ', true]]);

it('skips lookup for an incomplete postal code', function (): void {
    Http::fake();

    Livewire::test(addressComponent())->call('updateAddress', '123')->assertSet('address', null);

    Http::assertNothingSent();
});

it('resets a null address safely', function (): void {
    Livewire::test(addressComponent())->set('cityName', 'Campinas')->set('stateName', 'SP')
        ->call('resetAddress')->assertSet('address', null)->assertSet('cityName', null)->assertSet('stateName', null);
});

it('clears stale address fields while preserving the entered postal code', function (): void {
    $component = addressComponent();
    $address   = Address::factory()->make(['postal_code' => '13000-000']);
    $this->assertInstanceOf(Address::class, $address);
    $component->address   = $address;
    $component->cityName  = 'Campinas';
    $component->stateName = 'SP';

    $component->resetAddress();

    $this->assertInstanceOf(Address::class, $component->address);
    expect($component->address->only(['city_id', 'street', 'number', 'district', 'complement', 'postal_code']))->toBe([
        'city_id' => null, 'street' => null, 'number' => null, 'district' => null, 'complement' => null, 'postal_code' => '13000-000',
    ]);
    expect($component->cityName)->toBeNull()->and($component->stateName)->toBeNull();
});

it('reports invalid and missing postal codes with a null address', function (int $status, array $body, string $message): void {
    Http::fake(['https://viacep.com.br/ws/13000000/json/' => Http::response($body, $status)]);

    $component = Livewire::test(addressComponent())->call('updateAddress', '13000-000')
        ->assertHasErrors('address.postal_code')->assertSet('address', null);

    expect($component->instance()->getErrorBag()->first('address.postal_code'))->toBe($message);
})->with([[400, [], 'CEP inválido.'], [200, ['erro' => true], 'CEP não encontrado.']]);

it('reports external failures without crashing when address is null', function (string $failure): void {
    Http::fake(['https://viacep.com.br/ws/13000000/json/' => $failure === 'connection' ? Http::failedConnection() : Http::response('{', 200)]);

    Livewire::test(addressComponent())->call('updateAddress', '13000-000')
        ->assertDispatched('toast', title: 'Ocorreu um erro ao buscar o endereço.', type: Toast::Error->value)->assertSet('address', null);
})->with(['connection', 'json']);

it('reports a missing city and clears the feedback after a successful lookup', function (): void {
    Http::fake(['https://viacep.com.br/ws/13000000/json/' => Http::response(['localidade' => 'Campinas', 'uf' => 'SP', 'cep' => '13000-000'])]);

    $component = Livewire::test(addressComponent())->call('updateAddress', '13000-000')
        ->assertHasErrors('address.city_id')->assertSet('address.city_id', null)->assertSet('cityName', 'Campinas')->assertSet('stateName', 'SP');

    expect($component->instance()->getErrorBag()->first('address.city_id'))->toBe('Cidade não encontrada.');

    $city = City::factory()->for(State::factory()->state(['initials' => 'SP']))->create(['name' => 'Campinas']);

    $component->call('updateAddress', '13000-000')->assertHasNoErrors()->assertSet('address.city_id', $city->getKey());
});

it('clears a previously resolved address when a later lookup fails', function (): void {
    City::factory()->for(State::factory()->state(['initials' => 'SP']))->create(['name' => 'Campinas']);
    Http::fake(['https://viacep.com.br/ws/13000000/json/' => Http::sequence()
        ->push(['localidade' => 'Campinas', 'uf' => 'SP', 'cep' => '13000-000', 'logradouro' => 'Rua A'])
        ->push(['erro' => true])]);

    Livewire::test(addressComponent())->call('updateAddress', '13000-000')->assertSet('address.street', 'Rua A')
        ->call('updateAddress', '13000-000')->assertHasErrors('address.postal_code')
        ->assertSet('address.city_id', null)->assertSet('address.street', null)->assertSet('cityName', null)->assertSet('stateName', null);
});
