# MaaterMakers

While working at The AAT Project, our team's main responsibility was to develop a sister website, maatermakers.com. It was a static website when I started there and we began converting it to a dynamic website where users would be able to apply to join, then, if accepted, could create a profile for themselves where they would have control over what content was on their page.
This code is some that I wrote for different cases:
1. if a user forgets their password and needs a link to set a new one (forgotPassword.php)
2. if a user decides they want to change their password while logged in (changePassword.php)
 * asks them to input old and new password, then changes
3. a user-friendly interface through which the AAT vetting team could assess whether or not they want to accept applicants
 * pages for vetting team are automatically generated when a new applicant comes in
 * "ACCEPT" and "DENY" buttons are placed at bottom of page
 * next applicant to review is loaded when AAT member clicks either button
 * depending on which button was chosen, category 'accepted' or 'denied' in User database table changes to 1
  
