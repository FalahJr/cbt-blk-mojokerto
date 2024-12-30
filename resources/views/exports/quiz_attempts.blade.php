{{-- resources/views/exports/quiz_attempts.blade.php --}}
<table>
    <thead>
        <tr>
            <th>Ranking</th>
            <th>Nomor Peserta</th>
            <th>Nama Lengkap</th>
            <th>Quiz</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listQuizAttempt as $index => $attempt)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $attempt->nomor_peserta }}</td>
                <td>{{ $attempt->nama_lengkap }}</td>
                <td>{{ $attempt->quiz_name }}</td>
                <td>{{ $attempt->score }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
