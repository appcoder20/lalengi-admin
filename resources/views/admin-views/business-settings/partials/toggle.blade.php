@php($value = \App\Models\BusinessSetting::where('key', $key)->first())
@php($value = $value ? $value->value : 0)

<div class="col-sm-6 col-lg-4">
    <div class="form-group mb-0">
        <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
            <span class="pr-1 d-flex align-items-center switch--label">
                <span class="line--limit-1">{{ translate($label) }}</span>
                <span class="form-label-secondary text-danger d-flex"
                    data-toggle="tooltip" data-placement="right"
                    data-original-title="{{ translate('If_enabled,_feature_will_be_visible_to_users') }}">
                    <img src="{{ asset('/public/assets/admin/img/info-circle.svg') }}"
                         alt="{{ translate('messages.customer_varification_toggle') }}"> *
                </span>
            </span>
            <input type="checkbox"
                   data-id="{{ $key }}"
                   data-type="toggle"
                   data-image-on="{{ asset('/public/assets/admin/img/modal/mail-success.png') }}"
                   data-image-off="{{ asset('/public/assets/admin/img/modal/mail-warning.png') }}"
                   data-title-on="{{ translate('Want_to_enable_the') }} <strong>{{ translate($label) }}</strong>?"
                   data-title-off="{{ translate('Want_to_disable_the') }} <strong>{{ translate($label) }}</strong>?"
                   data-text-on="<p>{{ translate('If_enabled,_this_feature_will_be_shown_on_the_home_screen_or_relevant_section') }}</p>"
                   data-text-off="<p>{{ translate('If_disabled,_this_feature_will_be_hidden_from_users') }}</p>"
                   class="status toggle-switch-input dynamic-checkbox-toggle"
                   value="1"
                   name="{{ $key }}"
                   id="{{ $key }}"
                   {{ $value == 1 ? 'checked' : '' }}>
            <span class="toggle-switch-label text">
                <span class="toggle-switch-indicator"></span>
            </span>
        </label>
    </div>
</div>
