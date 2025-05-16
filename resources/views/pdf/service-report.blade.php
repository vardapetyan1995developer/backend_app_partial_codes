<x-pdf.layout title="{{ trans('messages.service_report.pdf.title') }}">
    <x-pdf.report.order-information
        :order="$order"
    />
    @if ($report)
    <x-pdf.page-break title="{{ trans('messages.service_report.pdf.title') }}" />
    <x-pdf.service-report.administration
        :report="$report"
        :worker="$order->worker"
    />
    @endif
</x-pdf.layout>
