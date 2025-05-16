<x-email.layout>
<x-email.title class="text-center">
{{ trans('messages.mail.dear_client', ['client' => $order->client->name]) }}
</x-email.title>
<x-email.note>
{{ trans('messages.mail.service_report.attachment', ['kitchen_number' => $order->kitchen_number]) }}
</x-email.note>
</x-email.layout>
