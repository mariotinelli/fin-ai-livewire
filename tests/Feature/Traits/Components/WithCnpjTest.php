<?php

declare(strict_types = 1);

use App\Enums\Toast;
use App\Traits\Components\WithCnpj;
use App\Traits\Components\WithToast;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Livewire;

class CnpjTestComponent extends Component
{
    use WithCnpj;
    use WithToast;

    public function render(): string
    {
        return '<div></div>';
    }
}

beforeEach(function (): void {
    Http::preventStrayRequests();
});

it('fills customer partners and address without a customer or user model', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/11444777000161' => Http::response([
        'razao_social'    => 'Empresa LTDA',
        'socios'          => [['nome' => 'Maria', 'cpf_cnpj_socio' => '123']],
        'estabelecimento' => [
            'nome_fantasia' => 'Empresa', 'ddd1' => '11', 'telefone1' => '33334444',
            'email'         => 'empresa@example.com', 'cidade' => ['nome' => 'São Paulo'],
            'estado'        => ['nome' => 'São Paulo'], 'logradouro' => 'Rua A', 'numero' => '10',
            'bairro'        => 'Centro', 'cep' => '01001000', 'complemento' => 'Sala 1',
        ],
    ])]);

    Livewire::test(CnpjTestComponent::class)->call('updateCustomerCnpj', '11.444.777/0001-61')
        ->assertSet('customer', ['name' => 'Empresa LTDA', 'phone' => '(11) 3333-4444', 'email' => 'empresa@example.com', 'nickname' => 'Empresa'])
        ->assertSet('partners', [['name' => 'Maria', 'document' => '123']])
        ->assertSet('cityName', 'São Paulo')->assertSet('stateName', 'São Paulo')
        ->assertSet('address.street', 'Rua A')->assertSet('address.number', '10')
        ->assertSet('address.district', 'Centro')->assertSet('address.postal_code', '01001-000')
        ->assertSet('address.complement', 'Sala 1')->assertNotDispatched('toast')
        ->call('updateCustomerCnpj', '11444777000161')->assertSet('customer.name', 'Empresa LTDA');

    Http::assertSentCount(2);
    $this->assertDatabaseCount('addresses', 0);
    $this->assertDatabaseCount('users', 0);
});

it('skips incomplete cnpj inputs', function (?string $cnpj): void {
    Livewire::test(CnpjTestComponent::class)->call('updateCustomerCnpj', $cnpj)
        ->assertSet('customer.name', '')->assertSet('address', null)->assertNotDispatched('toast');

    Http::assertNothingSent();
})->with([null, '', '0', '123', '12345678000190', '123456780001900', 'letters']);

it('accepts an officially supported alphanumeric CNPJ', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/00000000E08G12' => Http::response([
        'razao_social'    => 'Empresa Alfanumérica',
        'socios'          => [],
        'estabelecimento' => ['cnpj' => '00000000E08G12'],
    ])]);

    Livewire::test(CnpjTestComponent::class)
        ->call('updateCustomerCnpj', '00.000.000/e08g-12')
        ->assertSet('customer.name', 'Empresa Alfanumérica')
        ->assertNotDispatched('toast');

    Http::assertSentCount(1);
});

it('reports lookup failures and preserves existing form values', function (int $status): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/11444777000161' => Http::response([], $status)]);

    Livewire::test(CnpjTestComponent::class)->set('customer.name', 'Manter')
        ->set('partners', [['name' => 'Sócio', 'document' => '1']])
        ->set('cityName', 'Cidade atual')->call('updateCustomerCnpj', '11444777000161')
        ->assertSet('customer.name', 'Manter')->assertSet('cityName', 'Cidade atual')
        ->assertSet('partners', [['name' => 'Sócio', 'document' => '1']])->assertSet('address', null)
        ->assertDispatched('toast', title: 'Erro ao buscar o CNPJ, tente novamente mais tarde.', type: Toast::Error->value);
})->with([200, 400, 404, 504, 503]);

it('reports rate limits separately', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/11444777000161' => Http::response([], 429)]);

    Livewire::test(CnpjTestComponent::class)->call('updateCustomerCnpj', '11444777000161')
        ->assertDispatched('toast', title: 'Limite de consultas atingido, tente novamente após alguns minutos.', type: Toast::Error->value);
});

it('reports connection failures without crashing', function (): void {
    Http::fake(['https://publica.cnpj.ws/cnpj/11444777000161' => Http::failedConnection()]);

    Livewire::test(CnpjTestComponent::class)->call('updateCustomerCnpj', '11444777000161')
        ->assertSet('address', null)
        ->assertDispatched('toast', title: 'Erro ao buscar o CNPJ, tente novamente mais tarde.', type: Toast::Error->value);
});
