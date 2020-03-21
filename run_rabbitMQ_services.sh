#!/bin/bash
python notification/notification.py & 
python notification/telegram.py &
python notification/mail.py &
