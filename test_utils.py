#Author: Huzzein Adebiyi
#Class: Secure programming 
import os
import unittest
from contact_manager import ContactManager

class TestContactManager(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        cls.manager = ContactManager()
        cls.test_file = 'contacts.txt'
        
        # Ensure the file is empty at the start of the test
        with open(cls.test_file, 'w') as f:
            pass
    def test_add_contact(self):
        # Update to match the expected format
        self.manager.add_contact('Alice', 'alice@example.com', '1234567890')
        contacts = self.manager.get_contacts()
        self.assertIn('Alice', [contact['name'] for contact in contacts])


    def test_update_contact(self):
        # Test updating an existing contact
        self.manager.add_contact('Bob', 'bob@example.com', '+987654321')
        self.manager.update_contact('Bob', new_email='newbob@example.com')
        contacts = self.manager.get_contacts()
        bob = next((c for c in contacts if c['name'] == 'Bob'), None)
        self.assertEqual(bob['email'], 'newbob@example.com')

    def test_delete_contact(self):
        # Test deleting a contact
        self.manager.add_contact('Charlie', 'charlie@example.com', '+1122334455')
        self.manager.delete_contact('Charlie')
        contacts = self.manager.get_contacts()
        self.assertNotIn('Charlie', [contact['name'] for contact in contacts])

    def test_get_contacts(self):
        # Test retrieving the list of contacts
        self.manager.add_contact('Dave', 'dave@example.com', '+2233445566')
        contacts = self.manager.get_contacts()
        self.assertTrue(any(contact['name'] == 'Dave' for contact in contacts))

    @classmethod
    def tearDownClass(cls):
        # Clean up by deleting the test contacts file
        if os.path.exists(cls.test_file):
            os.remove(cls.test_file)

if __name__ == '__main__':
    unittest.main()
