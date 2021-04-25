@csrf
<div class="md-form">
    <label for=""></label>
    <input type="text" name="title" id="title" class="form-control" required value="{{ $article->title ?? old('title') }}" placeholder="タイトル">
</div>
<div class="form-group">
    <article-tags-input>
    </article-tags-input>
</div>
<div class="form-group">
    <label for=""></label>
    <textarea name="body" id="body-text" rows="16" class="form-control" placeholder="本文">{{ $article->body ?? old('body') }}</textarea>
</div>