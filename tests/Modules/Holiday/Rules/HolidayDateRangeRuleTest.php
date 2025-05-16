<?php

namespace Tests\Modules\Holiday\Rules;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Holiday\Rules\HolidayDateRangeRule;
use Tests\Modules\AbstractModuleTestCase as TestCase;

final class HolidayDateRangeRuleTest extends TestCase
{
    use WithFaker;

    public function testWithNonDateToString(): void
    {
        $rule = new HolidayDateRangeRule(
            $this->faker->dateTimeThisCentury()->format('Y-m-d')
        );

        foreach ([
            $this->faker->uuid(),
            $this->faker->sha256(),
        ] as $value) {
            $this->assertFalse(
                $rule->passes($this->faker->slug(), $value),
                sprintf('Rule passes with `%s` invalid date string', $value)
            );
        }
    }

    public function testWithNonDateFromString(): void
    {
        foreach ([
            $this->faker->uuid(),
            $this->faker->sha256(),
        ] as $value) {
            $rule = new HolidayDateRangeRule($value);

            $this->assertFalse(
                $rule->passes($this->faker->slug(), $this->faker->dateTimeThisCentury()->format('Y-m-d')),
                'Rule fails with invalid from string'
            );
        }
    }

    public function testWithMoreThanAYearDateRange(): void
    {
        $from = now()->startOfDay();
        $to = $from->clone()->addYears(1)->addDays(2);

        $rule = new HolidayDateRangeRule($from->toDateTimeString());

        $this->assertFalse(
            $rule->passes($this->faker->slug(), $to->toDateTimeString()),
            'Rule fails with a more than a year date range'
        );
    }

    public function testMessage(): void
    {
        $rule = new HolidayDateRangeRule($this->faker->dateTimeThisCentury()->format('Y-m-d'));

        $this->assertSame(trans('validation.holiday_date_range'), $rule->message());
    }
}
