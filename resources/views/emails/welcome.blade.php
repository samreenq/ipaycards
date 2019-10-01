<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->


    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    <style>

        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        }

        p,
        ul{
            color: #767475;
            font: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, "sans-serif";
        }
        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img + div {
            display: none !important;
        }

        ul.social{
            padding: 0;
            margin-bottom: 0px;
        }
        ul.social li{
            display: inline-block;
            margin-right: 10px;
            /*border: 1px solid #74b49b;*/
            padding: 10px;
            border-radius: 50%;
            background: rgba(0,0,0,.05);
            margin-bottom: 0px;
        }

        ul.icons{
            padding: 0;
        }

        ul.icons li{
            display: inline-block;
            /*border: 1px solid #74b49b;*/
            padding: 10px;
            padding-top: 0px;
        }
        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u ~ div .email-container {
                min-width: 320px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u ~ div .email-container {
                min-width: 375px !important;
            }
        }
        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u ~ div .email-container {
                min-width: 414px !important;
            }
        }

    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

        .primary{
            background: #f3a333;
        }

        .bg_white{
            /*background: #ffffff;*/
        }
        .bg_light{
            background: #F0F0F0;
        }
        .bg_black{
            background: #000000;
        }
        .bg_dark{
            background: rgba(0,0,0,.8);
        }
        .email-section{
            padding: 1em 2em;
        }

        /*BUTTON*/
        .btn{
            padding: 13px 85px;
        }
        .btn.btn-primary{
            border-radius: 30px;
            background: #00728C;
            color: #ffffff;

        }



        h1,h2,h3,h4,h5,h6{
            font-family: 'Playfair Display', serif;
            color: #000000;
            margin-top: 0;
        }

        body{
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(0,0,0,.4);
        }

        a{
            color: #26a6c3;
        }

        table{
        }
        /*LOGO*/

        .logo h1{
            margin: 0;
        }
        .logo h1 a{
            color: #000;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            font-family: 'Montserrat', sans-serif;
        }

        /*HERO*/
        .hero{
            position: relative;
        }
        .hero img{
            padding-left: 20px;
        }
        .hero .text{
            color: rgba(255,255,255,.8);
        }
        .hero .text h2{
            color: #ffffff;
            font-size: 30px;
            margin-bottom: 0;
        }


        /*HEADING SECTION*/
        .heading-section{
        }
        .heading-section h2{
            color: #000000;
            font-size: 28px;
            margin-top: 0;
            line-height: 1.4;
        }
        .heading-section .subheading{
            margin-bottom: 20px !important;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(0,0,0,.4);
            position: relative;
        }
        .heading-section .subheading::after{
            position: absolute;
            left: 0;
            right: 0;
            bottom: -10px;
            content: '';
            width: 100%;
            height: 2px;
            background: #f3a333;
            margin: 0 auto;
        }

        .heading-section-white{
            color: rgba(255,255,255,.8);
        }
        .heading-section-white h2{
            font-size: 28px;
            font-family:
            line-height: 1;
            padding-bottom: 0;
        }
        .heading-section-white h2{
            color: #ffffff;
        }
        .heading-section-white .subheading{
            margin-bottom: 0;
            display: inline-block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255,255,255,.4);
        }


        .icon{
            text-align: center;
        }
        .icon img{
        }


        /*SERVICES*/
        .text-services{
            padding: 0px 10px 0;
            text-align: left;
        }
        .text-services h3{
            font-size: 20px;
        }

        /*BLOG*/
        .text-services .meta{
            text-transform: uppercase;
            font-size: 14px;
        }

        /*TESTIMONY*/
        .text-testimony .name{
            margin: 0;
        }
        .text-testimony .position{
            color: rgba(0,0,0,.3);

        }


        /*VIDEO*/
        .img{
            width: 100%;
            height: auto;
            position: relative;
        }
        .img .icon{
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            bottom: 0;
            margin-top: -25px;
        }
        .img .icon a{
            display: block;
            width: 60px;
            position: absolute;
            top: 0;
            left: 50%;
            margin-left: -25px;
        }



        /*COUNTER*/
        .counter-text{
            text-align: left;
        }
        .counter-text .num{
            display: block;
            color: #ffffff;
            font-size: 34px;
            font-weight: 700;
        }
        .counter-text .name{
            display: block;
            color: rgba(255,255,255,.9);
            font-size: 13px;
        }


        /*FOOTER*/

        .footer{
            color: rgba(255,255,255,.5);

        }
        .footer .heading{
            color: #ffffff;
            font-size: 20px;
        }
        .footer ul{
            margin: 0;
            padding: 0;
        }
        .footer ul li{
            list-style: none;
            margin-bottom: 10px;
        }
        .footer ul li a{
            color: rgba(255,255,255,1);
        }

        hr {
            border: .5px solid #F0F0F0;
            width: 90%;
        }

        @media screen and (max-width: 500px) {

            .icon{
                text-align: left;
            }

            .text-services{
                padding-left: 0;
                padding-right: 20px;
                text-align: left;
            }

        }

    </style>


</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #fafafa;">
<center style="width: 100%; background-color: #F0F0F0;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 600px; margin: 0 auto;" class="email-container " >
        <!-- BEGIN BODY -->
        <table align="left" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" background-color: "#ffffff" style="background-color: #ffffff;">
        <tr>
            <td valign="top" class="bg_light" style="height:40px;">

            </td>
        </tr><!-- end tr -->
        <tr>
            <td>
                <img src="{!! url('/').'/public/web/img/emails/iPaycardsLogo.png' !!}" alt="" style="width: 70px; padding: 20px 10px 20px 20px">
            </td>
        </tr><!-- end tr -->
        <tr>
            <td>
                <img src="{!! url('/').'/public/web/img/emails/MainBanner.jpg' !!}" alt="" style="width: 560px; padding: 0 20px">
            </td>
        </tr><!-- end tr -->

        <tr> </tr><!-- end tr -->
        <tr>
            <td class="bg_white">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">

                    <tr>
                        <td class="email-section">
                            <div class="heading-section" style="text-align:left; padding: 0 0px;">
                                <p>Dear {!! $data['name'] !!}</p><p>Thanks for signing up to iPayCards – your gateway to fun and games.</p>
                                <p>On iPayCards you can find all your <b>favorite U.S. and U.K. store entertainment, gaming, shopping and music cards</b> or even recharge your phone, Salik and other. You can also buy gift cards for your friends use on our App and Website.</p>
                                <p>Here’s a preview of what’s in store for you – and remember, <b>its all digital so you can use your vouchers immediately!</b> </p>
                               <?php echo $data['body']; ?>
                        </td>
                    </tr><!-- end tr -->

                    <tr>
                        <td>
                            <img src="{!! url('/').'/public/web/img/emails/Brands.jpg' !!}" alt="" style="width: 560px; padding: 0 20px">
                        </td>
                    </tr><!-- end tr -->
                    <tr>
                        <td class="email-section">
                            <div class="heading-section" style="text-align:left; padding: 0 0px;">

                                <p> To get started, head back to our App or Website and begin shopping.</p>
                                <p>If you like what you see, you can also tell your friends and get rewards so you can shop more for less as long as you like.</p>
                                <p>We’re always here to help and listen to your feedback. Let us know what you think by emailing us on <a href="mailto:help@iPayCards.com">help@iPayCards.com</a> or Chat with us directly on our App and Website.</p>

                                <p>Have a great experience!<br>The iPayCards Team</p>

                        </td>
                    </tr>

    </div>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="100%" style="text-align: center;">
                <hr>
                <p style="text-align: center; color: #00728C; font-weight: bold; margin-bottom: 0px">Download our App!</p>
                <ul class="icons">
                    <li><a href="#"><img src="{!! url('/').'/public/web/img/emails/AppStore.jpg' !!}" alt="" style="width: 160px; max-width: 600px; height: auto; display: block;"></a></li>
                    <li><a href="#"><img src="{!! url('/').'/public/web/img/emails/GooglePlay.jpg' !!}" alt="" style="width: 160px; max-width: 600px; height: auto; display: block;"></a></li>
                </ul>
                <p><a href="#" class="btn btn-primary">VISIT iPAYCARDS.COM</a><br><br></p>

                <hr>
                <p>Terms and Conditions</p></td>
            </td>
        </tr>

    </table>
    </td>
    </tr><!-- end: tr -->
    <tr>


    </tr>

    <tr>
    </tr>
    </table>
    </td>
    </tr><!-- end: tr -->
    <tr> </tr><!-- end: tr -->

    <tr>
        <td class="bg_light email-section" style="padding: 0; width: 100%;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td valign="middle" width="50%">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">


                            <tr> </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr><!-- end: tr -->
    <tr>
        <td class="bg_light email-section" style="padding: 0; width: 100%;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr> </tr>
            </table>
        </td>
    </tr><!-- end: tr -->
    <tr>
        <td class="bg_light email-section" style="padding: 0; width: 100%;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td valign="middle" width="50%">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr> </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr><!-- end: tr -->
    <tr>
        <td class="bg_light email-section" style="padding: 0; width: 100%;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td valign="middle" width="50%">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr> </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr><!-- end: tr -->

    <tr> </tr><!-- end: tr -->
    <tr> </tr><!-- end: tr -->

    </table>

    </td>
    </tr><!-- end:tr -->
    <!-- 1 Column Text + Button : END -->
    </table>
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <td valign="top" class="bg_light" style="padding: 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" >
                <tr>
                    <td width="100%" style="text-align: center;">
                        <ul class="social">
                            <li><a href="https://twitter.com/ipaycards"><img src="{!! url('/').'/public/web/img/emails/004-twitter-logo.png' !!}" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                            <li><a href="https://www.facebook.com/IPayCards-291199848093951"><img src="{!! url('/').'/public/web/img/emails/005-facebook.png' !!}" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                            <li><a href="https://www.instagram.com/ipaycards/"><img src="{!! url('/').'/public/web/img/emails/006-instagram-logo.png' !!}" alt="" style="width: 16px; max-width: 600px; height: auto; display: block;"></a></li>
                        </ul>

                    </td>
                </tr>
            </table>
        </td>
        <tr> </tr><!-- end: tr -->
        <tr> </tr>
    </table>

    </div>
</center>
</body>
</html>