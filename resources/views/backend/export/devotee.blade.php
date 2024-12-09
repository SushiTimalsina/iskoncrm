<table>
    <thead>
    <tr>
        <th>First Name</th>
        <th>Middle Name</th>
        <th>Surname Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Gotra</th>
        <th>Phone</th>
        <th>Date of Birth</th>
        <th>Gender</th>
        <th>Blood Group</th>
        <th>Education</th>
        <th>Occupation</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Created Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($devotees as $devotee)
        <tr>
            <td>{{ $devotee->firstname }}</td>
            <td>{{ $devotee->middlename }}</td>
            <td>{{ $devotee->surname }}</td>
            <td>{{ $devotee->email }}</td>
            <td>{{ $devotee->mobile }}</td>
            <td>{{ $devotee->gotra }}</td>
            <td>{{ $devotee->phone }}</td>
            <td>{{ $devotee->dob }}</td>
            <td>{{ $devotee->gender }}</td>
            <td>{{ $devotee->bloodgroup }}</td>
            <td>{{ $devotee->education }}</td>
            <td>{{ $devotee->occupation }}</td>
            <td>{{ $devotee->status }}</td>
            <td>{{ $devotee->createdby }}</td>
            <td>{{ $devotee->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
