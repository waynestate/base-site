@extends('layouts.' . (!empty($base['layout']) ? $base['layout'] : 'main'))

@section('content')
    @include('components.page-title', ['title' => $base['page']['title']])

    <style>.formy fieldset legend { display:block; }</style>
    <div class="formy">

        <div class="form-description">
            <p>This sample form with error states</p>
        </div>

        <form action="/{{ $base['server']['path'] }}#form-1" method="post" id="form-1" class="content" name="form-1" enctype="multipart/form-data" tabindex="-1">
            <p id="required-message">Fields with asterisks (*) are required.</p>
            <div class="form-errors">
                <h2 id="form-errors" tabindex="-1">Error: There are 12 error(s) on the form</h2>
                <ul>
                    <li><strong>First Name:</strong> Field is required</li>
                    <li><strong>Last Name:</strong> Field is required</li>
                    <li><strong>Email:</strong> Field is required</li>
                    <li><strong>Address Line 1:</strong> Field is required</li>
                    <li><strong>City:</strong> Field is required</li>
                    <li><strong>State / Province / Region:</strong> Field is required</li>
                    <li><strong>Postal / Zip Code:</strong> Field is required</li>
                    <li><strong>Country:</strong> Field is required</li>
                    <li><strong>Single Line Text:</strong> Field is required</li>
                    <li><strong>Paragraph Text:</strong> Field is required</li>
                    <li><strong>Multiple Choice (Single Answer):</strong> Field is required</li>
                    <li><strong>Checkboxes (Multiple Answers):</strong> Field is required</li>
                    <li><strong>Drop Down (Single Answer):</strong> Field is required</li>
                    <li><strong>File Upload:</strong> Field is required</li>
                </ul>
            </div>
            <h2>Contact Information (autofilled if authenticated)</h2>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_first_name">
                    <label for="first_name">First Name <em>*</em></label>
                    <div class="error">
                        <input name="first_name" id="first_name" type="text" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-first_name" size="20" maxlength="50000" value="">
                        <p id="error-message-first_name">Field is required</p>
                    </div>
                </div>
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_last_name end">
                    <label for="last_name">Last Name <em>*</em></label>
                    <div class="error">
                        <input name="last_name" id="last_name" type="text" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-last_name" size="20" maxlength="50000" value="">
                        <p id="error-message-last_name">Field is required</p>
                    </div>
                </div>
            </div>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_email">
                    <label for="email">Email <em>*</em></label>
                    <div class="error">
                        <input name="email" id="email" type="email" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-email" size="20" maxlength="50000" value="">
                        <p id="error-message-email">Field is required</p>
                    </div>
                </div>
            </div>
            <h2>Address Long (group)</h2>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_address_line_1">
                    <label for="address_line_1">Address Line 1 <em>*</em></label>
                    <div class="error">
                        <input name="address_line_1" id="address_line_1" type="text" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-address_line_1" size="55" maxlength="50000" value="">
                        <p id="error-message-address_line_1">Field is required</p>
                    </div>
                </div>
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_address_line_2 end">
                    <label for="address_line_2">Address Line 2</label>
                    <input name="address_line_2" id="address_line_2" type="text" size="55" maxlength="50000" value="">
                </div>
            </div>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_city">
                    <label for="city">City <em>*</em></label>
                    <div class="error">
                        <input name="city" id="city" type="text" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-city" size="15" maxlength="50000" value="">
                        <p id="error-message-city">Field is required</p>
                    </div>
                </div>
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_state_province_region end">
                    <label for="state_province_region">State / Province / Region <em>*</em></label>
                    <div class="error">
                        <input name="state_province_region" id="state_province_region" type="text" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-state_province_region" size="15" maxlength="50000" value="">
                        <p id="error-message-state_province_region">Field is required</p>
                    </div>
                </div>
            </div>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_postal_zip_code">
                    <label for="postal_zip_code">Postal / Zip Code <em>*</em></label>
                    <div class="error">
                        <input name="postal_zip_code" id="postal_zip_code" type="text" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-postal_zip_code" size="15" maxlength="50000" value="">
                        <p id="error-message-postal_zip_code">Field is required</p>
                    </div>
                </div>
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_country end">
                    <label for="country">Country <em>*</em></label>
                    <div class="error">
                        <div class="select">
                            <select name="country" id="country" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-country">
                                <option value="">Please Select</option>
                                <option value="First Choice">First Choice</option>
                                <option value="Second Choice">Second Choice</option>
                                <option value="Third Choice">Third Choice</option>
                            </select>
                        </div>
                        <p id="error-message-country">Field is required</p>
                    </div>
                </div>
            </div>
            <h2>Heading</h2>
            <p>Text Block: Ability to put paragraph text blocks throughout the form.</p>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7591">
                    <label for="f_7591">Single Line Text <em>*</em></label>
                    <div class="error">
                        <input name="f_7591" id="f_7591" type="text" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7591" size="25" maxlength="50000" value="" placeholder="examples can be provided">
                        <p id="error-message-f_7591">Field is required</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7589">
                    <label for="f_7589">Paragraph Text <em>*</em></label>
                    <div class="error">
                        <div>
                            <textarea name="f_7589" id="f_7589" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7589" cols="50" rows="4" placeholder="Example copy"></textarea>
                        </div>
                        <p id="error-message-f_7589">Field is required</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7592">
                    <fieldset class="field_group">
                        <legend>Multiple Choice (Single Answer) <em>*</em></legend>
                        <div class="error">
                            <div class="radio">
                                <div>
                                    <input name="f_7592" type="radio" value="First Choice" id="f_7592_first-choice" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7592">
                                    <label for="f_7592_first-choice">First Choice</label>
                                </div>
                                <div>
                                    <input name="f_7592" type="radio" value="Second Choice" id="f_7592_second-choice" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7592">
                                    <label for="f_7592_second-choice">Second Choice</label>
                                </div>
                                <div>
                                    <input name="f_7592" type="radio" value="Third Choice" id="f_7592_third-choice" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7592">
                                    <label for="f_7592_third-choice">Third Choice</label>
                                </div>
                            </div>
                            <p id="error-message-f_7592">Field is required</p>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7593">
                    <fieldset class="field_group">
                        <legend>Checkboxes (Multiple Answers) <em>*</em></legend>
                        <div class="error">
                            <div class="checkbox">
                                <div>
                                    <input name="f_7593[]" type="checkbox" value="First Choice" id="f_7593_first-choice" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7593">
                                    <label for="f_7593_first-choice">First Choice</label>
                                </div>
                                <div>
                                    <input name="f_7593[]" type="checkbox" value="Second Choice" id="f_7593_second-choice" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7593">
                                    <label for="f_7593_second-choice">Second Choice</label>
                                </div>
                                <div>
                                    <input name="f_7593[]" type="checkbox" value="Third Choice" id="f_7593_third-choice" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7593">
                                    <label for="f_7593_third-choice">Third Choice</label>
                                </div>
                            </div>
                            <p id="error-message-f_7593">Field is required</p>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7594">
                    <label for="f_7594">Drop Down (Single Answer) <em>*</em></label>
                    <div class="error">
                        <div class="select">
                            <select name="f_7594" id="f_7594" class="required" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7594">
                                <option value="" selected="selected">Please Select</option>
                                <option value="First Choice">First Choice</option>
                                <option value="Second Choice">Second Choice</option>
                                <option value="Third Choice">Third Choice</option>
                            </select>
                        </div>
                        <p id="error-message-f_7594">Field is required</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7595">
                    <label for="f_7595">File Upload <em>*</em></label>
                    <div class="error">
                        <input name="f_7595" id="f_7595" type="file" aria-required="true" aria-invalid="true" aria-describedby="error-message-f_7595">
                        <p id="error-message-f_7595">Field is required</p>
                    </div>
                </div>
            </div>
            <input type="hidden" name="formy-save" value="1">
            <div class="row">
                <div class="xlarge-12 large-12 medium-12 small-12 columns">
                    <input type="submit" class="g-recaptcha button radius small secondary" id="formy-button" value="Submit">
                </div>
            </div>
            <script>
                (function() {
                    var first_error_field = document.querySelector("[aria-invalid='true']");
                    if (first_error_field) {
                        first_error_field.focus();
                    }
                })();
            </script>
        </form>
    </div>
@endsection
