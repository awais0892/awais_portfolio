<div style="font-family: sans-serif; color: #111;">
    <h2>New contact message</h2>
    <p><strong>Name:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> {{ $contact->email }}</p>
    <p><strong>Subject:</strong> {{ $contact->subject }}</p>
    <p><strong>Message:</strong></p>
    <div style="white-space: pre-wrap;">{{ $contact->message }}</div>
</div>
