#Author: Huzzein Adebiyi
#Class: Secure programming 
# contact_manager.py
import os
from utils import validate_email, validate_phone_number

class ContactManager:
    def __init__(self, filename='contacts.txt'):
        self.filename = filename
        # Ensure the contacts file exists
        if not os.path.isfile(self.filename):
            open(self.filename, 'w').close()

    def add_contact(self, name, email, phone):
        """Add a new contact after validating email and phone."""
        if not validate_email(email):
            raise ValueError("Invalid email format.")
        if not validate_phone_number(phone):
            raise ValueError("Invalid phone number format.")
        
        with open(self.filename, 'a') as f:
            f.write(f"{name},{email},{phone}\n")
        print(f"Contact '{name}' added successfully.")

    def get_contacts(self):
        """Retrieve all contacts from the file."""
        contacts = []
        with open(self.filename, 'r') as f:
            for line in f:
                name, email, phone = line.strip().split(',')
                contacts.append({'name': name, 'email': email, 'phone': phone})
        return contacts

    def update_contact(self, old_name, new_name=None, new_email=None, new_phone=None):
        """Update contact details by name."""
        updated = False
        contacts = self.get_contacts()
        with open(self.filename, 'w') as f:
            for contact in contacts:
                if contact['name'] == old_name:
                    contact['name'] = new_name if new_name else contact['name']
                    contact['email'] = new_email if new_email else contact['email']
                    contact['phone'] = new_phone if new_phone else contact['phone']
                    updated = True
                f.write(f"{contact['name']},{contact['email']},{contact['phone']}\n")
        if updated:
            print(f"Contact '{old_name}' updated successfully.")
        else:
            print(f"Contact '{old_name}' not found.")

    def delete_contact(self, name):
        """Delete a contact by name."""
        contacts = self.get_contacts()
        with open(self.filename, 'w') as f:
            for contact in contacts:
                if contact['name'] != name:
                    f.write(f"{contact['name']},{contact['email']},{contact['phone']}\n")
        print(f"Contact '{name}' deleted successfully.")
