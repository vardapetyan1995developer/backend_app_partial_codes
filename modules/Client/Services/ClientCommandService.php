<?php

namespace Modules\Client\Services;

use App\Models\User;
use App\Models\Client;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use Modules\Client\Dto\CreateClientDto;
use Modules\Client\Dto\UpdateClientDto;
use Modules\Client\Dto\UpdateClientPasswordDto;

final class ClientCommandService
{
    public function create(CreateClientDto $request): int
    {
        return DB::transaction(static function () use ($request): int {
            /** @var User $user */
            $user = User::create([
                'role' => UserRole::CLIENT,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'has_accepted_terms' => false,
            ]);

            $client = Client::create([
                'user_id' => $user->id,
                'company_name' => $request->companyName,
                'phone_number' => $request->phoneNumber,
                'kvk_number' => $request->kvkNumber,
                'btw_number' => $request->btwNumber,
                'btw_percent' => $request->btwPercent,
                'invoice_email' => $request->invoiceEmail,
                'invoice_for_attention' => $request->invoiceForAttention,
                'details' => $request->details,
                'billing_street' => $request->billingStreet,
                'billing_house_number' => $request->billingHouseNumber,
                'billing_addition' => $request->billingAddition,
                'billing_postcode' => $request->billingPostcode,
                'billing_city' => $request->billingCity,
                'billing_country' => $request->billingCountry,
            ]);

            Event::dispatch('client.created', $client->id);

            return $client->id;
        });
    }

    public function update(int $clientId, UpdateClientDto $request): void
    {
        DB::transaction(static function () use ($clientId, $request): void {
            $client = Client::query()->findOrFail($clientId);

            $client->update([
                'company_name' => $request->companyName,
                'phone_number' => $request->phoneNumber,
                'kvk_number' => $request->kvkNumber,
                'btw_number' => $request->btwNumber,
                'btw_percent' => $request->btwPercent,
                'invoice_email' => $request->invoiceEmail,
                'invoice_for_attention' => $request->invoiceForAttention,
                'details' => $request->details,
                'billing_street' => $request->billingStreet,
                'billing_house_number' => $request->billingHouseNumber,
                'billing_addition' => $request->billingAddition,
                'billing_postcode' => $request->billingPostcode,
                'billing_city' => $request->billingCity,
                'billing_country' => $request->billingCountry,
            ]);

            Event::dispatch('client.updated', $clientId);
        });
    }

    public function updatePassword(int $clientId, UpdateClientPasswordDto $request): void
    {
        DB::transaction(static function () use ($clientId, $request): void {
            User::query()
                ->whereHas('client', static fn ($b) => $b->where('clients.id', $clientId))
                ->firstOrFail()
                ->update(['password' => Hash::make($request->password)]);

            Event::dispatch('client.password_updated', $clientId);
        });
    }

    public function acceptTerms(int $clientId): void
    {
        DB::transaction(static function () use ($clientId): void {
            /** @var Client $client */
            $client = Client::findOrFail($clientId);

            $client->user->update([
                'has_accepted_terms' => true,
            ]);

            Event::dispatch('client.terms_accepted', $clientId);
        });
    }

    public function delete(int $clientId): void
    {
        DB::transaction(static function () use ($clientId): void {
            /** @var Client $client */
            $client = Client::findOrFail($clientId);

            $client->user()->delete();
            $client->delete();

            Event::dispatch('client.deleted', $clientId);
        });
    }
}
