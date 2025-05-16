<x-email.layout>
<x-email.title class="text-center">
{{ trans('messages.mail.dear_client', ['client' => $invoice->client->name]) }}
</x-email.title>
<x-email.note>
{{ trans('messages.mail.invoice.attachment', ['kitchen_number' => $invoice->order->kitchen_number]) }}
</x-email.note>
</x-email.layout>
