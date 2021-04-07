<div class="card mt-3">
    <div class="card-body d-flex flex-row">
        <i class="fas fa-user-circle fa-3x mr-1"></i>
        <div>
            <div class="font-weight-bold">{{ $article->user->name }}</div>
            <div class="font-weight-lighter">{{ $article->created_at->format('Y/m/d H:i') }}</div>
        </div>
        @if (Auth::id() === $article->user_id)
            <div class="ml-auto card-text">
                <div class="dropdown">
                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('articles.edit', ['article' => $article]) }}" class="dropdown-item">
                            <i class="fas fa-pen mr-1"></i>記事を更新する
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="" class="dropdown-item text-danger" data-toggle="modal"
                            data-target="#modal-delete-{{ $article->id }}">
                            <i class="fas fa-trash-alt mr-1"></i>記事を削除する
                        </a>
                    </div>
                </div>
            </div>

            {{-- modal --}}
            <div class="modal fade" id="modal-delete-{{ $article->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" type="button" data-dismiss="modal" aria-label="閉じる">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('articles.destroy', ['article' => $article]) }}" method="post">
                            @csrf
                            @method("DELETE")
                            <div class="modal-body">
                                {{ $article->title }} を削除します。よろしいですか?
                            </div>
                            <div class="modal-footer justify-content-between">
                                <a data-dismiss="modal" class="btn btn-outline-grey">キャンセル</a>
                                <button type="submit" class="btn btn-danger">削除する</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="card-body pt-0">
        <h3 class="h4 card-title">
            <a href="{{ route('articles.show', ['article' => $article]) }}" class="text-dark">
                {{ $article->title }}
            </a>
        </h3>
        <div class="card-text">
            {{ $article->body }}
        </div>
    </div>
</div>
