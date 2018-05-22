@extends('components.content-area')

@section('content')
    @include('components.page-title', ['title' => $page['title']])

    <div class="formy">
        <div class="form-description">
            <div class="form-description"><p>Example form using output version 3.</p></div>
        </div>

        <form action="/{{ $server['path'] }}" method="post" id="form-1" name="form-1" enctype="multipart/form-data" onsubmit="document.getElementById('formy-button').disabled=true; document.getElementById('formy-button').value='Submitting, please wait...';">
            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_first_name">
                    <label for="first_name">First Name <em>*</em></label>
                    <input name="first_name" id="first_name" type="text" class="required" size="20" maxlength="50000" value="">
                </div>

                <div class="xlarge-4 large-4 medium-12 small-12 columns field_last_name end">
                    <label for="last_name">Last Name <em>*</em></label>
                    <input name="last_name" id="last_name" type="text" class="required" size="20" maxlength="50000" value="">
                </div>
            </div>

            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_email end">
                    <label for="email">Email <em>*</em></label>
                    <input name="email" id="email" type="email" class="required" size="20" maxlength="50000" value="">
                </div>
            </div>

            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_address_line_1">
                    <label for="address_line_1">Address Line 1 <em>*</em></label>
                    <input name="address_line_1" id="address_line_1" type="text" class="required" size="55" maxlength="50000" value="">
                </div>

                <div class="xlarge-4 large-4 medium-12 small-12 columns field_address_line_2 end"><label for="address_line_2">Address Line 2</label><input name="address_line_2" id="address_line_2" type="text" size="55" maxlength="50000" value=""></div>
            </div>

            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_city">
                    <label for="city">City <em>*</em></label>
                    <input name="city" id="city" type="text" class="required" size="15" maxlength="50000" value="">
                </div>

                <div class="xlarge-4 large-4 medium-12 small-12 columns field_state_province_region end">
                    <label for="state_province_region">State / Province / Region <em>*</em></label>
                    <input name="state_province_region" id="state_province_region" type="text" class="required" size="15" maxlength="50000" value="">
                </div>
            </div>

            <div class="row field_group">
                <div class="xlarge-4 large-4 medium-12 small-12 columns field_postal_zip_code">
                    <label for="postal_zip_code">Postal / Zip Code <em>*</em></label>
                    <input name="postal_zip_code" id="postal_zip_code" type="text" class="required" size="15" maxlength="50000" value="">
                </div>

                <div class="xlarge-4 large-4 medium-12 small-12 columns field_country end">
                    <label for="country">Country <em>*</em></label>
                    <div class="select">
                        <select name="country" id="country" class="required">
                            <option value="">Please Select</option>
                            <option value="First Choice">First Choice</option>
                            <option value="Second Choice">Second Choice</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216246"><label for="f_216246">Single Line Text</label><input name="f_216246" id="f_216246" type="text" size="25" maxlength="50000" value="" placeholder="example"></div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216247">
                    <label for="f_216247">Paragraph Text</label>
                    <div><textarea name="f_216247" id="f_216247" cols="50" rows="4" placeholder="example"></textarea></div>
                </div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216248">
                    <label for="f_216248">Multiple Choice</label>
                    <div class="radio">
                        <div><input name="f_216248" type="radio" value="First Choice" id="f_216248_First Choice"><label for="f_216248_First Choice">First Choice</label></div>
                        <div><input name="f_216248" type="radio" value="Second Choice" id="f_216248_Second Choice"><label for="f_216248_Second Choice">Second Choice</label></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216249">
                    <label for="f_216249">Checkboxes</label>
                    <div class="checkbox">
                        <div><input name="f_216249[]" type="checkbox" value="First Choice" id="f_216249_First Choice"><label for="f_216249_First Choice">First Choice</label></div>
                        <div><input name="f_216249[]" type="checkbox" value="Second Choice" id="f_216249_Second Choice"><label for="f_216249_Second Choice">Second Choice</label></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216250">
                    <label for="f_216250">Dropdown</label>
                    <div class="select">
                        <select name="f_216250" id="f_216250">
                            <option value="" selected="selected">Please Select</option>
                            <option value="First Choice">First Choice</option>
                            <option value="Second Choice">Second Choice</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216251"><label for="f_216251">File</label><input name="f_216251" id="f_216251" type="file"></div>
            </div>

            <p>Example block of text</p>

            <h2>Heading - Error States</h2>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216254">
                    <label for="f_216254">Single Line Text <em>*</em></label>
                    <div class="error">
                        <input name="f_216254" id="f_216254" type="text" class="required" size="25" maxlength="50000" value="">
                        <p>Required</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216255">
                    <label for="f_216255">Paragraph Text <em>*</em></label>
                    <div class="error">
                        <div><textarea name="f_216255" id="f_216255" class="required" cols="50" rows="4"></textarea></div>
                        <p>Required</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216256">
                    <label for="f_216256">Multiple Choice <em>*</em></label>
                    <div class="error">
                        <div class="radio">
                            <div><input name="f_216256" type="radio" value="First Choice" id="f_216256_First Choice"><label for="f_216256_First Choice">First Choice</label></div>
                            <div><input name="f_216256" type="radio" value="Second Choice" id="f_216256_Second Choice"><label for="f_216256_Second Choice">Second Choice</label></div>
                        </div>
                        <p>Required</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216257">
                    <label for="f_216257">Dropdown <em>*</em></label>
                    <div class="error">
                        <div class="select">
                            <select name="f_216257" id="f_216257" class="required">
                                <option value="" selected="selected">Please Select</option>
                                <option value="First Choice">First Choice</option>
                                <option value="Second Choice">Second Choice</option>
                            </select>
                        </div>
                        <p>Required</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="xlarge-8 large-8 medium-12 small-12 columns field_f_216258">
                    <label for="f_216258">File <em>*</em></label>
                    <div class="error">
                        <input name="f_216258" id="f_216258" type="file">
                        <p>Required</p>
                    </div>
                </div>
            </div>

            <input type="hidden" name="formy-save" value="1">

            <div class="row">
                <div class="xlarge-12 large-12 medium-12 small-12 columns"><input type="submit" name="submit" class="button radius small secondary" id="formy-button" value="Submit"></div>
            </div>
        </form>
    </div>
@endsection
