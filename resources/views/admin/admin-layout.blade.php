<x-admin-header-css></x-admin-header-css>

<body>
    @php 
        $user = auth()->user(); 
    @endphp

    <x-admin-role-side-bar :user="$user" />
          
    
   @yield('content')

   <x-admin-footer-css></x-admin-footer-css>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.auto-hide-alert');
        if (alerts.length) {
            setTimeout(function () {
                alerts.forEach(function (alertEl) {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                        const alert = new bootstrap.Alert(alertEl);
                        alert.close();
                    } else {
                        // fallback: just hide
                        alertEl.style.display = 'none';
                    }
                });
            }, 4000); // 4 seconds
        }
    });
</script>

@stack('scripts')

 </body>

 </html>