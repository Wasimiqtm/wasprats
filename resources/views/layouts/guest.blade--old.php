<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

       <!-- <title>{{ config('app.name', 'Laravel') }}</title>-->
        
         <title>Pest Control Services | Wasprats</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Waspsrats is a Pest Control Services Uk, offering a range of services like rodent control, Wasp removal Services, Bee Removal Services, and more. Trusted by clients for many years." />
        <meta name="keywords" content="Pest Control services Uk, Pest Control Companies Uk ,Best Pest Control Companies Uk, Wasp nest removal Uk, Rodent Control Uk, Rodent control company Uk, Rat Exterminator services Uk, Wasp removal Services Uk, Bees removal Services Uk, Rat Control services Uk">
        <meta name="author" content="Codedthemes" />
        <!-- Favicon icon -->
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

        <link rel='stylesheet' href="{{ asset('wp-includes/css/dist/block-library/style.min6a4d.css') }}" type='text/css' media='all' />
        <link rel='stylesheet' href="{{ asset('wp-includes/css/classic-themes.min68b3.css') }}" type='text/css' media='all' />
        <link rel='stylesheet' href="{{ asset('wp-content/plugins/bold-page-builder/css/front_end/content_elements.crushcb95.css?ver=4.4.9') }}" type='text/css' media='all' />
        <link rel='stylesheet' href="{{ asset('wp-content/plugins/bold-page-builder/slick/slickcb95.css?ver=4.4.9') }}" type='text/css' media='all' />
        <link rel='stylesheet' href="{{ asset('wp-content/plugins/bt_cost_calculator/style.min6a4d.css?ver=6.1.1') }}" type='text/css' media='all' />
        <link rel='stylesheet' href="{{ asset('wp-content/plugins/contact-form-7/includes/css/stylese23c.css?ver=5.7') }}" type='text/css' media='all' />
        <link rel='stylesheet' href="{{ asset('wp-content/themes/avantage/style6a4d.css?ver=6.1.1') }}" type='text/css' media='screen' />
        <link rel='stylesheet' id='avantage-print-css' href="{{ asset('wp-content/themes/avantage/print6a4d.css?ver=6.1.1') }}" type='text/css' media='print' />
        <link rel='stylesheet' id='avantage-fonts-css' href='https://fonts.googleapis.com/css?family=Roboto%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%2C100italic%2C200italic%2C300italic%2C400italic%2C500italic%2C600italic%2C700italic%2C800italic%2C900italic%7CSarabun%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%2C100italic%2C200italic%2C300italic%2C400italic%2C500italic%2C600italic%2C700italic%2C800italic%2C900italic%7CSarabun%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%2C100italic%2C200italic%2C300italic%2C400italic%2C500italic%2C600italic%2C700italic%2C800italic%2C900italic%7CRoboto%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%2C100italic%2C200italic%2C300italic%2C400italic%2C500italic%2C600italic%2C700italic%2C800italic%2C900italic%7CRoboto+Condensed%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%2C100italic%2C200italic%2C300italic%2C400italic%2C500italic%2C600italic%2C700italic%2C800italic%2C900italic%7CSarabun%3A100%2C200%2C300%2C400%2C500%2C600%2C700%2C800%2C900%2C100italic%2C200italic%2C300italic%2C400italic%2C500italic%2C600italic%2C700italic%2C800italic%2C900italic&#038;subset=latin%2Clatin-ext&#038;ver=1.0.0' type='text/css' media='all' />
        <link rel='stylesheet' id='boldthemes-framework-css' href='wp-content/themes/avantage/framework/css/style6a4d.css?ver=6.1.1') }}" type='text/css' media='all' />
        <script type='text/javascript' src="{{ asset('wp-includes/js/jquery/jquery.mina7a0.js?ver=3.6.1') }}" id='jquery-core-js'></script>
        <script type='text/javascript' src="{{ asset('wp-includes/js/jquery/jquery-migrate.mind617.js?ver=3.3.2') }}" id='jquery-migrate-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/plugins/bold-page-builder/slick/slick.mincb95.js?ver=4.4.9') }}" id='bt_bb_slick-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/plugins/bold-page-builder/content_elements_misc/js/jquery.magnific-popup.mincb95.js?ver=4.4.9') }}" id='bt_bb_magnific-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/plugins/bold-page-builder/content_elements_misc/js/content_elementscb95.js?ver=4.4.9') }}" id='bt_bb-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/plugins/bt_cost_calculator/jquery.dd6a4d.js?ver=6.1.1') }}" id='btcc_dd-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/plugins/bt_cost_calculator/cc.main6a4d.js?ver=6.1.1') }}" id='btcc_main-js'></script>
        <!-- vendor css -->
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        
        <style>
            
        </style>
    </head>
    <body class="home page-template-default page page-id-106 bt_bb_plugin_active bt_bb_fe_preview_toggle btHeadingStyle_default btMenuLeftEnabled btMenuBelowLogo btStickyEnabled btHideHeadline btLightSkin btBelowMenu noBodyPreloader btSlantedRightButtons btLightAlternateHeader btNoSidebar btShopSaleTagDesignSlanted_right btMenuLeft btMenuHorizontal btMenuInitFinished btRemovePreloader">
        <div class="btPageWrap" id="top">
	        
            @include('layouts.header')
        
            {{ $slot }}

            @include('layouts.footer')

    </div><!-- /pageWrap -->

        <script type='text/javascript' src="{{ asset('wp-content/plugins/creative-mail-by-constant-contact/assets/js/block/submit9ba9.js?ver=1671028376') }}" id='ce4wp_form_submit-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/plugins/contact-form-7/includes/swv/js/indexe23c.js?ver=5.7') }}" id='swv-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/plugins/contact-form-7/includes/js/indexe23c.js?ver=5.7') }}" id='contact-form-7-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/themes/avantage/framework/js/fancySelect6a4d.js?ver=6.1.1') }}" id='fancySelect-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/themes/avantage/framework/js/header.misc6a4d.js?ver=6.1.1') }}" id='avantage-header-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/themes/avantage/framework/js/misc6a4d.js?ver=6.1.1') }}" id='avantage-misc-js'></script>
        <script type='text/javascript' src="{{ asset('wp-content/themes/avantage/framework/js/framework_misc6a4d.js?ver=6.1.1') }}" id='boldthemes-framework-misc-js'></script>
        <script type='text/javascript' id='boldthemes-framework-misc-js-after'>
			var boldthemes_dropdown = document.querySelector( ".widget_categories #cat" );
			function boldthemes_onCatChange() {
				if ( boldthemes_dropdown.options[boldthemes_dropdown.selectedIndex].value > 0 ) {
					location.href = "https://waspsrats.com/?cat="+boldthemes_dropdown.options[boldthemes_dropdown.selectedIndex].value;
				}
			}
			if ( boldthemes_dropdown !== null ) {
				boldthemes_dropdown.onchange = boldthemes_onCatChange;
			}
                
        </script>
        <script type='text/javascript' src="{{ asset('wp-content/plugins/bold-page-builder/content_elements/bt_bb_section/bt_bb_elements6a4d.js?ver=6.1.1') }}" id='bt_bb_elements-js'></script>
    </body>
</html>
