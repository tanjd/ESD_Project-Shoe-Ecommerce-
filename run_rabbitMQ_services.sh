#!/bin/bash
python notification/notification.py & 
python telegram/telegram.py &
python mail/mail.py &
