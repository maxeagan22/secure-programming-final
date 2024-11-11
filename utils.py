#Author: Huzzein Adebiyi
#Class: Secure programming 
# utils.py
import re

def validate_email(email):
    """Validate email format."""
    email_regex = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
    return re.match(email_regex, email) is not None

def validate_phone_number(phone):
    """Validate phone number format (simple check for numbers only)."""
    phone_regex = r'^\+?\d{10,15}$'  # Allows for international format with country code
    return re.match(phone_regex, phone) is not None
