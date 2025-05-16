<x-email.layout>
<div class="text-center">
<x-email.title>
{{ trans('messages.mail.password_reset.subject') }}<br />
</x-email.title>
<x-email.button :href="$url">
{{ trans('messages.mail.password_reset.reset') }}
</x-email.button>
<x-email.note class="text-small">
{{ trans('messages.mail.password_reset.do_not_follow') }}<br />
</x-email.note>
<x-email.note class="text-small">
{{ trans('messages.mail.password_reset.not_supported_link') }}<br />
<p class="text-underline">{{ $url }}</p>
</x-email.note>
</div>
</x-email.layout>
