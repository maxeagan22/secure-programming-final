#Author: Huzzein Adebiyi
#Class: Secure programming 
# tests/test_contact_manager.py
import os
import pytest
from contact_manager import ContactManager

@pytest.fixture
def contact_manager():
    # Setup a temporary file for testing
    manager = ContactManager(filename='test_contacts.txt')
    yield manager
    # Teardown - remove the temporary file after tests
    if os.path.isfile('test_contacts.txt'):
        os.remove('test_contacts.txt')

def test_add_contact(contact_manager):
    contact_manager.add_contact('John Doe', 'johndoe@example.com', '+1234567890')
    contacts = contact_manager.get_contacts()
    assert len(contacts) == 1
    assert contacts[0]['name'] == 'John Doe'

def test_update_contact(contact_manager):
    contact_manager.add_contact('John Doe', 'johndoe@example.com', '+1234567890')
    contact_manager.update_contact('John Doe', new_email='newemail@example.com')
    contacts = contact_manager.get_contacts()
    assert contacts[0]['email'] == 'newemail@example.com'

def test_delete_contact(contact_manager):
    contact_manager.add_contact('John Doe', 'johndoe@example.com', '+1234567890')
    contact_manager.delete_contact('John Doe')
    contacts = contact_manager.get_contacts()
    assert len(contacts) == 0

def test_invalid_email(contact_manager):
    with pytest.raises(ValueError):
        contact_manager.add_contact('John Doe', 'invalidemail', '+1234567890')

def test_invalid_phone(contact_manager):
    with pytest.raises(ValueError):
        contact_manager.add_contact('John Doe', 'johndoe@example.com', 'invalidphone')
