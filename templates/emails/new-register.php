<?php
$body = '<html> 
    <head> 
        <title> Mshop New Shop Register </title> 
    </head> 
    <body> 
        
        <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff">
	<tbody><tr>
    <td scope="col" valign="top" style="border:1px solid #cccccc">
      <table border="0" cellspacing="0" cellpadding="0" align="center">
        <tbody><tr>
			<td scope="col" valign="top" style="padding:20px"><table width="610" border="0" cellspacing="0" cellpadding="0" align="center">
              <tbody><tr>
                <td scope="col" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:13px;padding:0 0 20px"><strong>Hi '.esc_html($name).',</strong></td>
              </tr>
              <tr>
                <td scope="col" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:13px;padding:0 0 20px">
                    <p style="font-size:14px;font-weight:normal;line-height:2">Welcome to <strong>mShop</strong> : Video Shopping Platform - your partner in providing your customer in-personalized shopping experience. You are now set to supercharge your Customer Experience. Please find the portal credentials -</p>
					<ul style="list-style:none">
						<li><strong>Application URL: </strong><a href="https://on.mshop.live/#!/login" target="_blank">https://on.mshop.live/#!/login</a></li>
						<li><strong>User Credentials: </strong> '.esc_html($phone).'</li>
						<li><strong>Password: </strong> '.esc_html($password).'</li>
					</ul>
                </td>
              </tr>
			  <tr>
				<td><p style="font-size:14px;font-weight:normal;line-height:2">Your Shop mShop url for promotion to your customer – <a href="https://www.mshop.live/" target="_blank">mShop</a></p>
				<p style="font-size:14px;font-weight:normal;line-height:2">If you are confused at any step, just give us a shout by writing to us on <a href="mailto:Enquiry@mshop.live">Enquiry@mshop.live</a></p></td>
			  </tr>
			  <tr>
                <td scope="col" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:13px;padding:0 0 20px;font-weight:bold">With Kind Regards,<br>Team mShop</td>
              </tr>
            </tbody></table>
			</td>
        </tr>
      </tbody></table> 
      </td>
  </tr>
</tbody></table>
    </body> 
    </html>';
    ?>