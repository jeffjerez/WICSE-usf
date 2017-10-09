<?php
/* Set e-mail recipient */
$myemail = "jw@mail.usf.edu";

$ip=&_SERVER['REMOTE-ADDR'];
/* Check all form inputs using check_input function */
$name = check_input($_REQUEST['name']);
$subject ="New WICSE Feedback";
$email = check_input($_REQUEST['email']);
$message = check_input($_REQUEST['feedback']);

/* If e-mail is not valid show error message */
if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
{
show_error("E-mail address not valid");
}

if(IsInjected($email))
{
    echo "Bad email value!";
    exit;
}

/* Let's prepare the message for the e-mail */
$message = "

Name: $name
E-mail: $email

Message:
$message

Sent from: $ip
";

/* Send the message using mail() function */
mail($myemail, $subject, $message);

/* Send the user back to home page */
header('Location: index.html');

/* Functions we used */
function check_input($data, $problem='')
{
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
if ($problem && strlen($data) == 0)
{
show_error($problem);
}
return $data;
}

function show_error($myError)
{
?>
<html>
<body>

<p>Please correct the following error:</p>
<strong><?php echo $myError; ?></strong>
<p>Hit the back button and try again</p>

</body>
</html>
<?php
exit();
}

function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
?>