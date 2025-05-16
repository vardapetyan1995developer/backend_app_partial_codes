<?php

namespace Tests\Integration;

use Tests\CreatesApplication;
use Tests\Integration\Utils\Traits\WithSmsFake;
use Tests\Integration\Utils\Traits\WithMailFake;
use Tests\Integration\Utils\Traits\WithNotificationFake;
use Tests\Integration\Utils\Traits\WithSchemaAssertions;
use Tests\Integration\Utils\Traits\WithViewPdfResponses;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Integration\Utils\Traits\WithCurrentTimestampFake;
use Tests\Integration\Utils\SchemaAssertions\AssertFileSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertAdminSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertOrderSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertClientSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertWorkerSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertContactSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertHolidaySchema;
use Tests\Integration\Utils\SchemaAssertions\AssertInvoiceSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertOrderLogSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertFmcaReportSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertImcaReportSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertSuperAdminSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertInvoiceItemSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertKitchenPerDaySchema;
use Tests\Integration\Utils\SchemaAssertions\AssertServiceReportSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertServiceWorkflowSchema;
use Tests\Integration\Utils\SchemaAssertions\AssertMechanicWorkflowSchema;

abstract class AbstractIntegrationTestCase extends BaseTestCase
{
    use CreatesApplication,
        WithSchemaAssertions,
        WithViewPdfResponses,
        WithMailFake,
        WithNotificationFake,
        WithCurrentTimestampFake,
        WithSmsFake;

    private $schemaAssertions = [
        AssertSuperAdminSchema::class,
        AssertAdminSchema::class,
        AssertClientSchema::class,
        AssertWorkerSchema::class,
        AssertContactSchema::class,
        AssertFileSchema::class,
        AssertOrderSchema::class,
        AssertOrderLogSchema::class,
        AssertImcaReportSchema::class,
        AssertFmcaReportSchema::class,
        AssertInvoiceSchema::class,
        AssertMechanicWorkflowSchema::class,
        AssertInvoiceItemSchema::class,
        AssertHolidaySchema::class,
        AssertKitchenPerDaySchema::class,
        AssertServiceWorkflowSchema::class,
        AssertServiceReportSchema::class,
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTestResponseMacros();
        $this->setUpViewPdfWrapper();
        $this->setUpMailFake();
        $this->setUpNotificationFake();
        $this->setUpSmsFake();
    }

    public function tearDown(): void
    {
        $this->tearDownTestResponseMacros();
        $this->tearDownViewPdfWrapper();
        $this->tearDownMailFake();
        $this->tearDownNotificationFake();
        $this->tearDownSmsFake();

        parent::tearDown();
    }
}
