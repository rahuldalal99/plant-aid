from __future__ import print_function
import pickle
import base64
from  email.mime.text import *
from email.mime.image import *
from email.mime.multipart import MIMEMultipart
import os.path
import mimetypes
import json
from googleapiclient.discovery import build
from google_auth_oauthlib.flow import InstalledAppFlow
from google.auth.transport.requests import Request
import sys

# If modifying these scopes, delete the file token.pickle.
SCOPES = ['https://www.googleapis.com/auth/gmail.readonly','https://www.googleapis.com/auth/gmail.compose','https://www.googleapis.com/auth/gmail.send']

def create_message(sender, to, subject,message_text,img):
  """Create a message for an email.

  Args:
    sender: Email address of the sender.
    to: Email address of the receiver.
    subject: The subject of the email message.
    message_text: The text of the email message.

  Returns:
    An object containing a base64url encoded email object.
  """
  message=MIMEMultipart()
  msgt = MIMEText(message_text)
  message.attach(msgt)
  print("send to",to)
  message['to'] = to
  message['from'] = sender
  message['subject'] = subject
  #message['body'] = body
  content_type, encoding = mimetypes.guess_type(img)
  main_type, sub_type = content_type.split('/', 1)
  fp=open(img,'rb')
  msg = MIMEImage(fp.read(), _subtype=sub_type)
  fp.close()
  filename=os.path.basename(img)
  msg.add_header('Content-Disposition', 'attachment', filename=filename)
  message.attach(msg)
  return {'raw': base64.urlsafe_b64encode(message.as_string().encode('utf-8'))}

def send_message(service, user_id, message):
  """Send an email message.

  Args:
    service: Authorized Gmail API service instance.
    user_id: User's email address. The special value "me"
    can be used to indicate the authenticated user.
    message: Message to be sent.

  Returns:
    Sent Message.
  """

  try:
    
    message["raw"]=message["raw"].decode('utf-8')
    #message=json.dumps(j)
    message = (service.users().messages().send(userId=user_id, body=message)
               .execute())
    print ('Message Id: %s' % message['id'])
    return message
  except Exception as error:
    print ('An error occurred: %s'% error)

def mail(to="cuisineplanner@gmail.com",msg="Support Request",body='"For user USER_TEST, predicted disease is DIS_PRED\n Please find attached email below',img='tcurl.jpg'):
    """Shows basic usage of the Gmail API.
    Lists the user's Gmail labels.
    """
    creds = None
    # The file token.pickle stores the user's access and refresh tokens, and is
    # created automatically when the authorization flow completes for the first
    # time.
    if os.path.exists('config/token.pickle'):
        with open('config/token.pickle', 'rb') as token:
            creds = pickle.load(token)
    # If there are no (valid) credentials available, let the user log in.
    if not creds or not creds.valid:
        if creds and creds.expired and creds.refresh_token:
            creds.refresh(Request())
        else:
            flow = InstalledAppFlow.from_client_secrets_file(
                'config/credentials.json', SCOPES)
            creds = flow.run_local_server(port=0)
        # Save the credentials for the next run
        with open('config/token.pickle', 'wb') as token:
            pickle.dump(creds, token)

    service = build('gmail', 'v1', credentials=creds)

    # Call the Gmail API
    message=create_message('medivine.ai@gmail.com',to,msg,body,img)
    print(send_message(service,'me',message))

if __name__ == '__main__':
    try:
        to=sys.argv[1]
        mail(to=to)
    except:
        print("default")
        mail()
