
{{--
    Responsive mail template for:
    Email for user activation - sent to administrator by App/Mail/userActivation
--}}

<style>
    @media  only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }
        .footer {
            width: 100% !important;
        }
    }
    @media  only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>

<table class="wrapper" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td style="box-sizing: border-box;" align="center">
                <table style="box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;" class="content" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td style="box-sizing: border-box; padding: 25px 0; text-align: center;" class="header">
                                <a moz-do-not-send="true" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href="#">Global CI Calendar</a>
                            </td>
                        </tr>

                        <!-- Email Body -->
                        <tr>
                            <td style="box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;" cellspacing="0" cellpadding="0" class="body" width="100%">
                                <table style="box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;" class="inner-body" align="center" cellpadding="0" cellspacing="0" width="570">
                                    <!-- Body content -->
                                    <tbody>
                                        <tr>
                                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;" class="content-cell">
                                                <h1 style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #2F3133; font-size: 19px; font-weight: bold; margin-top: 0; text-align: left;">Hello administrator
                                                </h1>
                                                <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">A new user has registered on the CI Global calendar website.</p>
                                                <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Name: {{$name}}</p>
                                                <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Email: {{$email}}</p>
                                                <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Country: {{$country}}</p>
                                                <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Description: {{$description}}</p>
                                                <table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;" class="action" align="center" cellpadding="0" cellspacing="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;" align="center">
                                                                <table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;" align="center">
                                                                                <table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;" border="0" cellpadding="0" cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                                                <a moz-do-not-send="true" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;" target="_blank" class="button button-blue"
                                                                                                    href="{{env('APP_URL')}}verify-user/{{$activation_code}}">
                                                                                                    Activate user
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-top: 1px solid #EDEFF2; margin-top: 25px; padding-top: 25px;" class="subcopy" cellpadding="0" cellspacing="0" width="100%">
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; line-height: 1.5em; margin-top: 0; text-align: left; font-size: 12px;">If you’re having trouble clicking the "Activate user" button, copy and paste the URL below into your web browser: <a moz-do-not-send="true" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #3869D4;" href="{{env('APP_URL')}}verify-user/{{$activation_code}}">{{env('APP_URL')}}verify-user/{{$activation_code}}</a></p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                <table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;" class="footer" align="center" cellpadding="0" cellspacing="0" width="570">
                                    <tbody>
                                        <tr>
                                            <td style="box-sizing: border-box; padding: 35px;" class="content-cell" align="center">
                                                <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #AEAEAE; font-size: 12px; text-align: center;">
                                                    © 2018 CI Global Calendar. All rights reserved.
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
