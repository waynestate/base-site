@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <style>.formy fieldset legend { display:block; }</style>
    <div class="formy">
        <div class="form-description">
            <div class="form-description">
                <p>Example form using output version 3.</p>
            </div>
        </div>

        <form action="/{{ $server['path'] }}#form-1" method="post" id="form-1" name="form-1" enctype="multipart/form-data" tabindex="-1">
            <p id="required-message">Fields with asterisks (*) are required.</p>
            <h2>Contact Information (autofilled if authenticated)</h2>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_first_name">
                    <label for="first_name">First Name <em>*</em></label>
                    <input name="first_name" id="first_name" type="text" class="required" aria-required="true" size="20" maxlength="50000" value="" />
                </div>
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_last_name end">
                    <label for="last_name">Last Name <em>*</em></label>
                    <input name="last_name" id="last_name" type="text" class="required" aria-required="true" size="20" maxlength="50000" value="" />
                </div>
            </div>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_email">
                    <label for="email">Email <em>*</em></label>
                    <input name="email" id="email" type="email" class="required" aria-required="true" size="20" maxlength="50000" value="" />
                </div>
            </div>
            <h2>Address Long (group)</h2>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_address_line_1">
                    <label for="address_line_1">Address Line 1 <em>*</em></label>
                    <input name="address_line_1" id="address_line_1" type="text" class="required" aria-required="true" size="55" maxlength="50000" value="" />
                </div>
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_address_line_2 end">
                    <label for="address_line_2">Address Line 2</label>
                    <input name="address_line_2" id="address_line_2" type="text" size="55" maxlength="50000" value="" />
                </div>
            </div>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_city">
                    <label for="city">City <em>*</em></label>
                    <input name="city" id="city" type="text" class="required" aria-required="true" size="15" maxlength="50000" value="" />
                </div>
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_state_province_region end">
                    <label for="state_province_region">State / Province / Region <em>*</em></label>
                    <input name="state_province_region" id="state_province_region" type="text" class="required" aria-required="true" size="15" maxlength="50000" value="" />
                </div>
            </div>
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_postal_zip_code">
                    <label for="postal_zip_code">Postal / Zip Code <em>*</em></label>
                    <input name="postal_zip_code" id="postal_zip_code" type="text" class="required" aria-required="true" size="15" maxlength="50000" value="" />
                </div>
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_country end">
                    <label for="country">Country <em>*</em></label>
                    <div class="select">
                        <select name="country" id="country" class="required" aria-required="true">
                            <option value="">Please Select</option>
                            <option value="First Choice">First Choice</option>
                            <option value="Second Choice">Second Choice</option>
                            <option value="Third Choice">Third Choice</option>
                        </select>
                    </div>
                </div>
            </div>
            <h2>Heading</h2>
            <p>Text Block: Ability to put paragraph text blocks throughout the form.</p>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7591">
                    <label for="f_7591">Single Line Text</label>
                    <input name="f_7591" id="f_7591" type="text" size="25" maxlength="50000" value="" placeholder="examples can be provided" />
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7589">
                    <label for="f_7589">Paragraph Text</label>
                    <div>
                        <textarea name="f_7589" id="f_7589" cols="50" rows="4">You can provide a Default Value or Example within the field.</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7592">
                    <fieldset class="field_group">
                        <legend>Multiple Choice (Single Answer)</legend>
                        <div class="radio">
                            <div>
                                <input name="f_7592" type="radio" value="First Choice" id="f_7592_first-choice" />
                                <label for="f_7592_first-choice">First Choice</label>
                            </div>
                            <div>
                                <input name="f_7592" type="radio" value="Second Choice" id="f_7592_second-choice" />
                                <label for="f_7592_second-choice">Second Choice</label>
                            </div>
                            <div>
                                <input name="f_7592" type="radio" value="Third Choice" id="f_7592_third-choice" />
                                <label for="f_7592_third-choice">Third Choice</label>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7593">
                    <fieldset class="field_group">
                        <legend>Checkboxes (Multiple Answers)</legend>
                        <div class="checkbox">
                            <div>
                                <input name="f_7593[]" type="checkbox" value="First Choice" id="f_7593_first-choice" />
                                <label for="f_7593_first-choice">First Choice</label>
                            </div>
                            <div>
                                <input name="f_7593[]" type="checkbox" value="Second Choice" id="f_7593_second-choice" />
                                <label for="f_7593_second-choice">Second Choice</label>
                            </div>
                            <div>
                                <input name="f_7593[]" type="checkbox" value="Third Choice" id="f_7593_third-choice" />
                                <label for="f_7593_third-choice">Third Choice</label>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7594">
                    <label for="f_7594">Drop Down (Single Answer)</label>
                    <div class="select">
                        <select name="f_7594" id="f_7594">
                            <option value="" selected="selected">Please Select</option>
                            <option value="First Choice">First Choice</option>
                            <option value="Second Choice">Second Choice</option>
                            <option value="Third Choice">Third Choice</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_7595">
                    <label for="f_7595">File Upload</label>
                    <input name="f_7595" id="f_7595" type="file" />
                </div>
            </div>
            <input type="hidden" name="formy-save" value="1" />
            <div class="row">
                <div class="xlarge-12 large-12 medium-12 small-12 columns">
                    <input type="submit" class="g-recaptcha button radius small secondary" id="formy-button" value="Submit" />
                </div>
            </div>
        </form>
    </div>
@endsection
