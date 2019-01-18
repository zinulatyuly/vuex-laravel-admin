{{-- Dependencies --}}
<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="{{ url('vendor/adminlte/js') }}/bootstrap.min.js"></script>
<script src="{{ url('vendor/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ url('vendor/adminlte/plugins/datepicker/locales/bootstrap-datepicker.ru.js') }}"></script>
{{-- AdminLTE --}}
<script src="{{ url('vendor/adminlte/js/app.min.js') }}"></script>

{{-- Vue --}}
<script src="{{ mix('admin/js/app.js') }}" type="text/javascript" charset="utf-8"></script>
@yield('javascript')
