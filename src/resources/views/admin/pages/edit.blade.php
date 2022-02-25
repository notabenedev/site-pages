@extends("admin.layout")

@section("page-title", "{$page->title} - ")

@section('header-title', "{$page->title}")

@section('admin')
    @include("site-pages::admin.pages.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.pages.update", ["page" => $page]) }}" method="post"  enctype="multipart/form-data">
                    @csrf
                    @method("put")

                    <div class="form-group">
                        <label for="title">Заголовок <span class="text-danger">*</span></label>
                        <input type="text"
                               id="title"
                               name="title"
                               maxlength="100"
                               required
                               value="{{ old("title", $page->title) }}"
                               class="form-control @error("title") is-invalid @enderror">
                        @error("title")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">Адресная строка</label>
                        <input type="text"
                               id="slug"
                               name="slug"
                               maxlength="100"
                               value="{{ old("slug", $page->slug) }}"
                               class="form-control @error("slug") is-invalid @enderror">
                        @error("slug")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="custom-file-input">Изображение</label>
                        <div class="custom-file">
                            <input type="file"
                                   class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                   id="custom-file-input"
                                   lang="ru"
                                   name="image"
                                   aria-describedby="inputGroupImage">
                            <label class="custom-file-label"
                                   for="custom-file-input">
                                Выберите файл
                            </label>
                            @if ($errors->has('image'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="short">Краткое описание</label>
                        <input type="text"
                               id="short"
                               maxlength="150"
                               name="short"
                               value="{{ old("short", $page->short) }}"
                               class="form-control @error("short") is-invalid @enderror">
                        @error("short")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea class="form-control tiny @error("description") is-invalid @enderror"
                                  name="description"
                                  id="description"
                                  rows="3">{{ old('description') ? old('description') : $page->description }}</textarea>
                        @error("description")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="accent">{{ config("site-pages.sitePageAccentName") }}</label>
                        <input type="text"
                               id="accent"
                               maxlength="100"
                               name="accent"
                               value="{{ old('accent') ? old('accent') : $page->accent }}"
                               class="form-control @error("accent") is-invalid @enderror">
                        @error("accent")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="comment">{{ config("site-pages.sitePageCommentName") }}</label>
                        <textarea class="form-control tiny @error("comment") is-invalid @enderror"
                                  name="comment"
                                  id="comment"
                                  maxlength="500"
                                  rows="2">{{ old('comment') ? old('comment') : $page->comment }}</textarea>
                        @error("comment")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="btn-group"
                         role="group">
                        <button type="submit" class="btn btn-success">Обновить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection