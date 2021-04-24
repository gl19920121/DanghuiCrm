<form action="{{ route('resumes.destroy', $resume) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button class="nav-link" type="submit" name="button">删除</button>
</form>
