{{--
    Mailing list subscribe form, posting directly to the WSU Formy
    subscriptions service. Requires a Formy subscribe form to already be
    set up for the site (list, form_id, and reCAPTCHA sitekey all come from that form).

    $data => array [
        ['title', 'description', 'relative_url', 'filename_alt_text']
        ... Promotion item from "id" field
    ]
    $component => array [
        "filename" => "listserv-subscribe-row",
        "list" => "your-list-slug", // Required. Formy subscriptions list slug.
        "form_id" => "4970", // Required. Formy form id, e.g. from "form-4970".
        "sitekey" => "your-recaptcha-sitekey", // Required. Google reCAPTCHA site key for the form.
        "id" => 000000, // Optional. Promotion group ID providing heading, description, and image.
        "campaign" => [], // Optional. Extra query params appended to the form action.
        "formHeading" => "Subscribe to our mailing list", // Optional fallback when no promo group is used.
        "image" => "/path/to/image.png", // Optional fallback image.
    ]
--}}
@if(!empty($component['list']) && !empty($component['form_id']) && !empty($component['sitekey']))
    @php
        $item = current($data) ?: [];
        $formId = 'form-'.$component['form_id'];
        $headingLevel = !empty($component['heading']) ? 'h3' : 'h2';
        $headingText = $item['title'] ?? $component['formHeading'] ?? 'Subscribe to our mailing list';
        $image = $item['relative_url'] ?? $component['image'] ?? null;
        $imageAlt = $item['filename_alt_text'] ?? 'decorative';
        $actionUrl = 'https://forms.wayne.edu/subscriptions/?'.http_build_query(array_merge(['list' => $component['list']], $component['campaign'] ?? []));
    @endphp

    <div class="flex flex-col md:flex-row md:items-center">
        @if(!empty($image))
            <div class="w-32 md:w-40 mx-auto md:mx-0 shrink-0 mb-6 md:mb-0">
                @image($image, $imageAlt, 'w-full')
            </div>
        @endif

        <div class="w-full {{ !empty($image) ? 'md:pl-6' : '' }}">
            <{{ $headingLevel }} class="mb-2">{{ $headingText }}</{{ $headingLevel }}>

            @if(!empty($item['description']))
                <div class="content mb-4">{!! $item['description'] !!}</div>
            @endif

            <form action="{{ $actionUrl }}" method="post" name="{{ $formId }}" id="{{ $formId }}" class="validate" novalidate>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <label for="{{ $formId }}-first_name">Name *</label>
                        <div class="mt-1 w-full">
                            <input name="first_name" id="{{ $formId }}-first_name" type="text" class="border rounded w-full py-2 required" size="20" maxlength="100" value="">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="{{ $formId }}-email">Email address *</label>
                        <div class="mt-1 w-full">
                            <input name="email" id="{{ $formId }}-email" type="email" class="border rounded w-full py-2 required" required size="20" maxlength="100" value="">
                        </div>
                    </div>
                    <div class="mt-4 md:mt-7 md:col-span-1">
                        <input type="submit" value="Subscribe" name="Submit" class="green-button py-3 w-full g-recaptcha" data-sitekey="{{ $component['sitekey'] }}" data-callback="onSubscribeSubmit_{{ $component['form_id'] }}">
                    </div>
                </div>
                <input name="f_28431" type="hidden" value="Subscribe">
                <input name="f_28436" type="hidden" value="{{ $component['list'] }}">
                <input name="last_name" type="hidden" value="">
                <input type="hidden" name="formy-save" value="{{ $component['form_id'] }}">
            </form>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>
    <script>
        function onSubscribeSubmit_{{ $component['form_id'] }}(token) {
            var subscribeForm = document.getElementById('{{ $formId }}'),
                fullName = subscribeForm.elements['first_name'].value,
                firstName = fullName.split(' ')[0];

            subscribeForm.elements['first_name'].value = firstName;
            subscribeForm.elements['last_name'].value = fullName.substring(firstName.trim().length);

            subscribeForm.submit();
        }
    </script>
@endif
