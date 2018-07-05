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
    <p style="height: 0; overflow: hidden; font-size: 0; line-height: 0;">$Booking.FirstName $Booking.Surname has booked a consultation session<% if $Booking.Slot %> at $Booking.Slot.Title<% end_if %>.</p>
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
                                                <dl>
                                                    <dt><strong>Appointment Time</strong></dt>
                                                    <dd>
                                                        <blockquote class="no-tilt">
                                                            <% if $Slot %>
                                                                $Slot.Title
                                                            <% else %>
                                                                <em>* Pleaes contact me to arrange *</em>
                                                            <% end_if %>
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
                                                <p class="has-text-centered"><u><a href="{$baseURL}admin/session-bookings/Booking/EditForm/field/Booking/item/{$Booking.ID}/edit" target="_blank">View the booking on the website</a></u></p>
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
                                            <td class="bg-white has-text-centered">
                                                <p style="font-size: 12px;">Success Global Website</p>
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
