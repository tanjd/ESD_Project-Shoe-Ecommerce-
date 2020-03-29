import smtplib
import os
import imghdr
from email.message import EmailMessage

# EMAIL_ADDRESS = os.environ.get('EMAIL_USER')
# EMAIL_PASSWORD = os.environ.get('EMAIL_PASS')

EMAIL_ADDRESS = 'g2t3esd@gmail.com'
EMAIL_PASSWORD = 'Qwertyuiop1!'
code = "Jeddy"
msg = EmailMessage()
msg['Subject'] = 'Hello world'
msg['From'] = EMAIL_ADDRESS
msg['To'] = 'jeddy.tan.2018@smu.edu.sg'
msg.set_content('This is a plain text email')

msg.add_alternative("""\
<!DOCTYPE html>
<html>
    <body>
        <h1 style="color:SlateGray;">This is an HTML Email!</h1>
    </body>
</html>
""".format(code=code), subtype='html')
# files = ['adidas-001.jpg', 'adidas-002.jpg']

# for file in files:
#     with open('../image/' + file, 'rb') as f:
#         file_data = f.read()
#         file_type = imghdr.what(f.name)
#         file_name = f.name
#         print(file_name)
#     msg.add_attachment(file_data, maintype='image', subtype= file_type, filename=file_name)

with smtplib.SMTP_SSL('smtp.gmail.com', 465) as smtp:
    smtp.login(EMAIL_ADDRESS, EMAIL_PASSWORD)
    smtp.send_message(msg)
    # subject = 'Hello world'
    # body = 'Hello ESD g2t3'
    # msg = f'Subject: {subject}\n\n{body}'
    # smtp.sendmail(EMAIL_ADDRESS, 'jeddy.tan.2018@smu.edu.sg', msg)
