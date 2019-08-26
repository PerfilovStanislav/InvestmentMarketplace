<?php
namespace Views\Emails; {
/**
 * @var ConfirmEmail $this
 * @property User   $user
 * @property string $code
 * @property LocaleInterface $locale
 */
Class ConfirmEmail {} }

use Interfaces\LocaleInterface;
use Models\Table\User;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AdminDesigns Email Template - Welcome</title>
    <style type="text/css">
        /* Take care of image borders and formatting, client hacks */
        img { max-width: 600px; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
        a img { border: none; }
        table { border-collapse: collapse !important;}
        #outlook a { padding:0; }
        .ReadMsgBody { width: 100%; }
        .ExternalClass { width: 100%; }
        .backgroundTable { margin: 0 auto; padding: 0; width: 100% !important; }
        table td { border-collapse: collapse; }
        .ExternalClass * { line-height: 115%; }
        .min-width-600 { min-width: 600px; }


        /* General styling */
        * {
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            margin: 0 !important;
            height: 100%;
            color: #676767;
        }

        td {
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 16px;
            color: #777777;
            text-align: center;
            line-height: 21px;
        }

        a {
            color: #676767;
            text-decoration: none !important;
        }

        .header-lg {
            font-size: 32px;
            font-weight: 600;
            line-height: normal;
            padding: 20px 0 0;
            color: #4d4d4d;
        }

        .content-padding {
            padding: 20px 0 30px;
        }

        .free-text {
            width: 100% !important;
            padding: 10px 60px 0px;
        }

        .block-rounded {
            border-radius: 5px;
            border: 1px solid #e5e5e5;
            vertical-align: top;
        }

        .button {
            padding: 30px 0;
        }

        .first {
            font-size: 36px;
            color: #0af;
            text-shadow: -1px 1px 1px #00425f;
        }

        .second {
            color: #f33;
            text-shadow: -1px 1px 1px #722;
            font-size: 32px;
        }

    </style>
</head>
<body bgcolor="#ffffff">
<table align="center" cellpadding="0" cellspacing="0" class="min-width-600" width="100%">
    <tr>
        <td align="center" valign="top" width="100%" style="    background-color: #f7f7f7;" class="content-padding">
            <center>
                <img width="96" height="96" src="<?=SITE?>/assets/icons/android-chrome-192x192.png" alt=""/>
                <table cellspacing="0" cellpadding="0" width="600">
                    <tr>
                        <td class="header-lg">
                            Hi <?=$this->user->name?>
                        </td>
                    </tr>
                    <tr>
                        <td class="header-lg">
                            <?=$this->locale['welcome_to']?> <a class="navbar-brand" href="<?=SITE?>"> <b class="first">Rich</b><b class="second">inMe</b> </a>!
                        </td>
                    </tr>
                    <tr>
                        <td class="button">
                            <a class="button-mobile" href="<?=SITE?>/Users/confirm/code/<?=$this->code?>" style="background-color:#4a89dc;border-radius:5px;color:#ffffff;display:inline-block;font-family:'Open Sans', Helvetica, Arial, sans-serif;font-size:18px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;"><?=$this->locale['verify_account']?></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?=$this->locale['or_copy_link']?>: <?=SITE?>/Users/confirm/code/<?=$this->code?>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
</body>
</html>
