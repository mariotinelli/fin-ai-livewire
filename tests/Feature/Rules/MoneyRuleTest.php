<?php

declare(strict_types = 1);

use App\Enums\Rules;
use App\Rules\MoneyRule;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Translation\PotentiallyTranslatedString;

class TestableMoneyRule extends MoneyRule
{
    public function orderedRulesProxy(): array
    {
        return $this->correctOrderRules();
    }

    public function hasRuleProxy(Rules $rule): bool
    {
        return $this->hasRule($rule);
    }
}

it('rejects non scalar monetary values without crashing validation', function (mixed $value): void {
    $messages = [];
    $fail     = function (string $message) use (&$messages): void {
        $messages[] = $message;
    };

    new MoneyRule()->default()->validate('total', $value, $fail);

    expect($messages)->toHaveCount(1);
})->with([[['amount' => 100]], true, false]);

it('validates values using between, min and max rules', function (): void {
    $failMessages = [];
    $fail         = function (string $message, ?string $attribute = null) use (&$failMessages): PotentiallyTranslatedString {
        $failMessages[] = $message;

        return new PotentiallyTranslatedString($message, app(Translator::class));
    };

    $rule = new MoneyRule()
        ->between(10, 20)
        ->min(10)
        ->max(20);

    $rule->validate('total', '15,00', $fail);

    expect($failMessages)->toBeEmpty();

    $rule->validate('total', '5,00', $fail);
    expect($failMessages)->not->toBeEmpty();
});

it('returns default rule and skips empty between/min values', function (): void {
    $failMessages = [];
    $fail         = function (string $message, ?string $attribute = null) use (&$failMessages): PotentiallyTranslatedString {
        $failMessages[] = $message;

        return new PotentiallyTranslatedString($message, app(Translator::class));
    };

    $rule = new MoneyRule()->default()->between(10, 20)->min(10);
    $rule->validate('total', null, $fail);

    expect($failMessages)->toBeEmpty();
});

it('orders rules according to money rule precedence', function (): void {
    $rule = new TestableMoneyRule();
    $rule->max(50)->between(10, 40)->min(5);

    expect(array_keys($rule->orderedRulesProxy()))->toBe([
        Rules::Between->value,
        Rules::Min->value,
        Rules::Max->value,
    ])
        ->and($rule->hasRuleProxy(Rules::Min))->toBeTrue()
        ->and($rule->hasRuleProxy(Rules::Required))->toBeFalse();
});

it('reports values above the configured maximum', function (): void {
    $message = null;
    $rule    = new MoneyRule()->max(10);

    $rule->validate('total', '10,01', function (string $failure, ?string $attribute = null) use (&$message): PotentiallyTranslatedString {
        $message = $failure;

        return new PotentiallyTranslatedString($failure, app(Translator::class));
    });

    expect($message)->toContain(currency(10));
});

it('ignores unknown extension rules without rejecting valid values', function (): void {
    $rule = new class () extends MoneyRule {
        public function addUnknownRule(): void
        {
            $this->rules['unknown'] = [];
        }
    };
    $rule->addUnknownRule();
    $rule->max(20);

    $failure = null;

    $rule->validate('total', '10,00', function (string $message, ?string $attribute = null) use (&$failure): PotentiallyTranslatedString {
        $failure = $message;

        return new PotentiallyTranslatedString($message, app(Translator::class));
    });

    expect($failure)->toBeNull();
});
