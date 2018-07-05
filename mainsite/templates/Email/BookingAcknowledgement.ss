<!doctype html>
<!--Quite a few clients strip your Doctype out, and some even apply their own. Many clients do honor your doctype and it can make things much easier if you can validate constantly against a Doctype.-->
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$Title</title>
    <style type="text/css">
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
        }
        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        /* What it does: Forces Outlook.com to display emails full width. */
        .ExternalClass {
            width: 100%;
        }
        /* What is does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }
        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table, td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }
        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            max-width: 100% !important;
            height: auto !important;
            -ms-interpolation-mode: bicubic;
        }
        /* What it does: Overrides styles added when Yahoo's auto-senses a link. */
        .yshortcuts a {
            border-bottom: none !important;
        }
        /* What it does: Another work-around for iOS meddling in triggered links. */
        a[x-apple-data-detectors] {
            color: inherit !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="$CSSURL">
</head>
<body yahoo="yahoo">
    <p style="height: 0; overflow: hidden; font-size: 0; line-height: 0;">Dear $Booking.FirstName, thank you for choosing Success Global.</p>
    <table class="super-ancestor-table" width="100%" cellspacing="0" cellpadding="0" align="center">
        <tbody>
            <tr>
                <td class="main-container super-ancestor-table-td">
                    <table class="ancestor-table top-stripe" width="100%" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td class="main-container">
                                    <!-- start -->
                                    <!--[if !mso]><!-- -->
                                    <!--<![endif]-->
                                    <table class="alpha-center-table maintain-table-on-mobile" width="600" cellpadding="0" cellspacing="0">
                                        <tr class="align-vertical-center">
                                            <td class="col-left has-text-centered">
                                                <a href="$baseURL" target="_blank">
                                                    <img src="{$baseURL}themes/default/images/logo-white.png" alt="Success Global Logo" width="80" />
                                                </a>
                                            </td>
                                            <td class="col-right">
                                                <p>immigration . business consultating . career management</p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- end -->
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="ancestor-table" width="100%" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td class="main-container">
                                    <!-- start -->
                                    <!--[if !mso]><!-- -->
                                    <!--<![endif]-->
                                    <table class="alpha-center-table maintain-table-on-mobile bg-white" width="600" cellpadding="0" cellspacing="0">
                                        <tr class="align-vertical-center">
                                            <td class="slogan has-text-right">
                                                <p>your partner in <span class="is-gold">success</span></p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- end -->
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="ancestor-table" width="100%" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td class="main-container">
                                    <table class="alpha-center-table maintain-table-on-mobile bg-white" width="600" cellpadding="0" cellspacing="0">
                                        <tr class="align-vertical-center">
                                            <td class="content has-text-left">
                                                <% with $Booking %>
                                                <h2 class="title is-2 is-marginless">Ref: $Title</h2>
                                                <p class="subtitle is-6"><strong>Submitted at</strong>: $Created</p>
                                                <h3 class="title is-4">Dear $FirstName,</h3>
                                                <p>Thank you for choosing Success Global.<br /><br />
                                                <% if $Slot %>
                                                We are pleased to confirm your <strong>$Slot.Duration</strong> Minutes Personalised Consultation with our Licensed Immigration Adviser <strong>Mr. Fahim Gul</strong> (LIAN: 201400662) is now booked for {$Slot.Title}.<br /><br />
                                                Please keep an eye on your inbox within the next 24 hours, as one of our team members will be in touch with you regarding further information and documents required in order for you to get the best out of your consultation.<br /><br />
                                                In the meantime, please do feel free to contact us by replying to this email and we will get back to you as soon as possible.<br /><br />
                                                <% else %>
                                                Because you haven't yet booked your session, we will liaise you shortly to arrange it.<br /><br />
                                                <% end_if %>
                                                Have a nice day.</p>

                                                <p>Best regards,<br /><strong>Team@SG</strong></p>
                                                <hr />
                                                <p><em>Below is a copy of your booking information</em>:</p>
                                                <dl>
                                                    <dt><strong>Appointment Time</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            $Slot.Title
                                                        </blockquote>
                                                    </dd>
                                                    <dt><strong>Full Name</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            $FirstName $Surname
                                                        </blockquote>
                                                    </dd>
                                                    <dt><strong>Contact Number</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            <a href="tel:$ContactNumber">$ContactNumber</a>
                                                        </blockquote>
                                                    </dd>
                                                    <dt><strong>Email</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            <a href="mailto:$Email">$Email</a>
                                                        </blockquote>
                                                    </dd>
                                                    <dt><strong>Current VISA</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            $CurrentVisa
                                                        </blockquote>
                                                    </dd>
                                                    <dt><strong>Applying VISA</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            $IntendVisa
                                                        </blockquote>
                                                    </dd>
                                                    <dt><strong>Current Situation</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            $HTMLSituation
                                                        </blockquote>
                                                    </dd>
                                                    <dt><strong>Additional Information</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            $HTMLAddtionalInfo
                                                        </blockquote>
                                                    </dd>
                                                    <dt><strong>Passport Bio Page</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            <% if $PassportBio %>
                                                            - see attachment -
                                                            <% else %>
                                                            - not provided -
                                                            <% end_if %>
                                                        </blockquote>
                                                    </dd>
                                                    <dt><strong>VISA Label</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            <% if $VisaLabel %>
                                                            - see attachment -
                                                            <% else %>
                                                            - not provided -
                                                            <% end_if %>
                                                        </blockquote>
                                                    </dd>
                                                </dl>
                                                <% end_with %>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="ancestor-table" width="100%" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td class="main-container">
                                    <table class="alpha-center-table maintain-table-on-mobile bg-white" width="600" cellpadding="0" cellspacing="0">
                                        <tr class="align-vertical-center">
                                            <td class="separator has-text-centered">
                                                <p>&nbsp;</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="ancestor-table purple" width="100%" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td class="main-container">
                                    <!-- start -->
                                    <table class="alpha-center-table" width="600" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td class="bg-white">
                                                <table class="alpha-center-table closure" width="600" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                            <p><strong>Toll Free Number:</strong></p>
                                                            <p><a href="tel:0508 484 727">0508 484 727</a></p>
                                                            <p><strong>E:</strong> <a href="mailto:info@successglobal.nz">info@successglobal.nz</a></p>
                                                            <p><strong>W:</strong> <a href="https://www.successglobal.nz" target="_blank">www.successglobal.nz</a></p>
                                                        </td>
                                                        <td class="mid">
                                                            <p><strong>Head Office:</strong></p>
                                                            <p>Suite G16, 1 Clyde Quay Wharf Te Aro, Wellington 6011, New Zealand</p>
                                                            <p><strong>T:</strong> <a href="tel:0064 4 499 3776">+64 4 499 3776</a></p>
                                                        </td>
                                                        <td>
                                                            <p><strong>Christchurch Branch:</strong></p>
                                                            <p>Unit No 1, <span>7 Bur<span>dale St, <span>Christchurch 8041</span>, New Zealand</p>
                                                            <p><strong>T:</strong> <a href="tel:0064 3 261 9409">+64 3 261 9409</a></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- end -->
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="ancestor-table" width="100%" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                            <tr>
                                <td class="main-container">
                                    <table class="alpha-center-table maintain-table-on-mobile bg-white" width="600" cellpadding="0" cellspacing="0">
                                        <tr class="align-vertical-center">
                                            <td class="separator has-text-centered">
                                                <p>&nbsp;</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </tbody>
</body>
</html>
