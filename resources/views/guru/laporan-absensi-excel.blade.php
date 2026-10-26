<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($absensi as $index => $a)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $a->user->name ?? '-' }}</td>
            <td>{{ $a->tanggal }}</td>
            <td>{{ $a->jam_masuk ?? '-' }}</td>
            <td>{{ $a->jam_pulang ?? '-' }}</td>
            <td>{{ $a->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>