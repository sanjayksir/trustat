<p></p>
<table cellpadding="0" cellspacing="0" style="font-size: 0px; width: 100%; background: #ffffff; border-top: 3px solid #fead0d;" align="center" border="0">
   <tbody>
      <tr>
         <td style="text-align: center; vertical-align: top; font-size: 0px; padding: 40px 30px 30px 30px;">
            <div style="vertical-align: top; display: inline-block; font-size: 13px; text-align: left; width: 100%;">
               <table cellpadding="0" cellspacing="0" width="100%" border="0">
                  <tbody>
                     <tr>
                        <td style="word-break: break-word; font-size: 0px; padding: 0px; padding-bottom: 30px;" align="center">
                           <table cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-spacing: 0px;" align="center" border="0">
                              <tbody>
                                 <tr>
                                    <td style="width: 250px;">
                                       <h2>Tracking Portal</h2>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td style="padding: 0px; padding: 10px 10px;" align="left">
                           <div style="color: #55575d; font-family: Open Sans,Helvetica,Arial,sans-serif; font-size: 15px; font-weight:600; line-height: 22px;">
                              <ul style="list-style:none;">
                                 <li>User Name: <?= $user_name ?></li>
                                 <li>Email: <?= $email ?></li>
                                 <li>MObile No: <?= $mobile_no ?></li>
                                 <li>Gender: <?= $gender ?></li>
                                 <li>Date of birth: <?= $dob ?></li>
                              </ul>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td style="word-break: break-word; font-size: 0px; padding: 0px; padding-bottom: 35px;" align="center">
                           <div style="color: #8c8c8c; font-family: Roboto,Helvetica,Arial,sans-serif; font-size: 14px; line-height: 22px;">We just need to validate your email address to activate your Tracking Portal account. Simply click the following button:</div>
                        </td>
                     </tr>
                     <tr>
                        <td style="word-break: break-word; font-size: 0px; padding: 0px;" align="center">
                           <div style="color: #8c8c8c; font-family: Roboto,Helvetica,Arial,sans-serif; font-size: 14px; line-height: 22px;"></div>
                        </td>
                     </tr>
                     <tr>
                        <td style="word-break: break-word; font-size: 0px; padding: 0px; padding-bottom: 40px;" align="center">
                           <table cellpadding="0" cellspacing="0" style="border-collapse: separate;" align="center" border="0">
                              <tbody>
                                 <tr>
                                    <td style="border-radius: 2px; color: #fff; padding: 10px 25px;" align="center" valign="middle" bgcolor="#fead0d"><a href="<?= site_url('/emailverify/'.urlencode(md5($email)).'/'. urlencode($email)); ?>" style="display: inline-block; text-decoration: none; background: #fead0d; color: #fff; font-family: Roboto,Helvetica,Arial,sans-serif,Helvetica,Arial,sans-serif; font-size: 14px; font-weight: normal; margin: 0px;" target="_blank" rel="noopener"> Activate my account </a></td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td style="word-break: break-word; font-size: 0px; padding: 0px; padding-bottom: 8px;" align="center">
                           <div style="color: #8c8c8c; font-family: Roboto,Helvetica,Arial,sans-serif; font-size: 14px; line-height: 22px;">If the link doesn't work, copy this URL into your browser:</div>
                        </td>
                     </tr>
                     <tr>
                        <td style="word-break: break-word; font-size: 0px; padding: 0px; padding-bottom: 35px;" align="center">
                            <div style="color: #3586ff; font-family: Roboto,Helvetica,Arial,sans-serif; font-size: 14px; line-height: 22px;"><a href="<?= site_url('/emailverify/'. urlencode(md5($email)).'/'. urlencode($email)); ?>" style="text-decoration: none; color: inherit;" target="_blank" ><?= site_url('/emailverify/'.urlencode(md5($email)).'/'. urlencode($email)); ?></a></div>
                        </td>
                     </tr>
                     <tr>
                        <td style="word-break: break-word; font-size: 0px; padding: 0px;" align="left">
                           <div style="color: #8c8c8c; font-family: Roboto,Helvetica,Arial,sans-serif; font-size: 14px; line-height: 22px;">Regards!</div>
                        </td>
                     </tr>
                     <tr>
                        <td style="word-break: break-word; font-size: 0px; padding: 0px;" align="left">
                           <div style="color: #8c8c8c; font-family: Roboto,Helvetica,Arial,sans-serif; font-size: 14px; line-height: 22px;">Tracking Portal Team</div>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </td>
      </tr>
   </tbody>
</table>