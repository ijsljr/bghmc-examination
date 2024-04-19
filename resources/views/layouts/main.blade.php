<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')


    <body onLoad="startTime()">
        <div id="app">
            
            @include('includes.messages')

            @include('includes.navbar')
            
            <main class="py-4" style="margin-left: 5%; margin-right: 5%">
                @yield('content')
            </main>

            @include('includes.footer')

            @include('includes.script')
        </div>
    </body>
</html>
