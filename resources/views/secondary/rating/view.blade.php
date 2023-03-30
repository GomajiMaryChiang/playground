@extends('modules.common')

@section('content')
    <div class="product-head-wrapper help-wrapper help-contact theme-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="theme-header text-center">查看評價</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- End:product-head-wrapper -->
    <main class="main main-contact">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb mt-2">
                        <ol class="breadcrumb rating">
                            <li class="breadcrumb-item"><a href="{{ url('') }}">首頁</a></li>
                            <li class="breadcrumb-item active" aria-current="page">查看評價</li>
                        </ol>
                    </nav>
                    <!-- End:breadcrumb -->
                </div>
                <div class="col-lg-11 col-md-11 col-sm-12">
                    <div class="help-contact-wrapper rating-wrapper border border-r">
                        <div class="row justify-content-md-center">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <div class="rating-viewBox">
                                    <p class="text-center sub-title mb-2 t-12">您此次的消費滿意度評分</p>
                                    <label class="rating-smile mb-2 rating_{{ $data['score'] }}">
                                        <span rating="1">&nbsp;</span>
                                        <span rating="2">&nbsp;</span>
                                        <span rating="3">&nbsp;</span>
                                        <span rating="4">&nbsp;</span>
                                        <span rating="5">&nbsp;</span>
                                    </label>
                                    <!-- 評分二星以下 -->
                                    @if (!empty($data['feature']))
                                        @if ($data['score'] < 3)
                                            <p class="text-center mb-2 t-12">您此次的消費不滿意的原因</p>
                                        @else
                                            <!-- 評分三星以上 -->
                                            <p class="text-center mb-2 t-12">您此次的消費最推薦的項目</p>
                                        @endif
                                        <p class="text-center mb-2 t-10 t-gray">{{ $data['feature'] }}</p>
                                    @endif
                                    <hr>
                                </div>
                                <div class="messageBox">
                                    @if (!empty($data['message']))
                                    <div class="message relative">
                                        <div class="comment">{{ $data['message'] }}<br><span class="t-gray">{{ $data['create_ts'] }}</span></div>
                                        <div class="head">
                                            <img width="48px" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iNDhweCIgaGVpZ2h0PSI0OHB4IiB2aWV3Qm94PSIwIDAgNDggNDgiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8dGl0bGU+cGVvcGxlX2ljb25fYmx1ZTwvdGl0bGU+CiAgICA8ZyBpZD0icGVvcGxlX2ljb25fYmx1ZSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPGNpcmNsZSBpZD0iT3ZhbCIgZmlsbD0iI0I2RDFGRiIgY3g9IjI0IiBjeT0iMjQiIHI9IjI0Ij48L2NpcmNsZT4KICAgICAgICA8ZyBpZD0iaWNvbi9teV9vcmRlcl9mb3JtLWNvcHkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDExLjAwMDAwMCwgOC4wMDAwMDApIiBmaWxsPSIjNDM3NEUwIj4KICAgICAgICAgICAgPHBhdGggZD0iTTEzLjA2NDA4MTUsMCBDOC4xNjgyNTUwMSwwIDQuMTk1MjAyMSwzLjkzMTY5MTY4IDQuMTk1MjAyMSw4Ljc3NjU1MDQ2IEM0LjE5NTIwMjEsMTMuNjIxNDA5MiA4LjE2ODI1NTAxLDE3LjU1MzEwMDkgMTMuMDY0MDgxNSwxNy41NTMxMDA5IEMxNy45NTk5MDgsMTcuNTUzMTAwOSAyMS45MzI5NjA5LDEzLjYyMTQwOTIgMjEuOTMyOTYwOSw4Ljc3NjU1MDQ2IEMyMS45MzI5NjA5LDMuOTMxNjkxNjggMTcuOTY4NDUyMiwwIDEzLjA2NDA4MTUsMCBMMTMuMDY0MDgxNSwwIEwxMy4wNjQwODE1LDAgWiBNMCwyNS42NTQ5NDUxIEwwLDMyIEwyNiwzMiBMMjYsMjUuNjU0OTQ1MSBDMjYsMjIuMDQxNjY3NiAyMy4xNTQ3ODE1LDE5LjEzNTMzNTcgMTkuNjE3NDgyNywxOS4xMzUzMzU3IEw2LjM4MjUxNzI1LDE5LjEzNTMzNTcgQzIuODQ1MjE4NTMsMTkuMTM1MzM1NyAwLDIyLjA0MTY2NzYgMCwyNS42NTQ5NDUxIFoiIGlkPSJteV9wZXJzb25hbF9zZXR0aW5nX2ljb24iPjwvcGF0aD4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPg==" alt="留言">
                                        </div>
                                    </div>
                                    @endif
                                   
                                    @if (!empty($data['store_message']))
                                        <div class="message message-store relative">
                                            <div class="comments">{{ $data['store_message'] }}<br><span class="t-gray">{{ $data['store_create_ts'] }}</span></div>
                                            <div class="head-store">
                                                <img width="48px" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz4KPHN2ZyB3aWR0aD0iNDhweCIgaGVpZ2h0PSI0OHB4IiB2aWV3Qm94PSIwIDAgNDggNDgiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CiAgICA8dGl0bGU+cGVvcGxlX2ljb25fb3JhbmdlPC90aXRsZT4KICAgIDxnIGlkPSJwZW9wbGVfaWNvbl9vcmFuZ2UiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPgogICAgICAgIDxjaXJjbGUgaWQ9Ik92YWwiIGZpbGw9IiNGRkRGQjMiIGN4PSIyNCIgY3k9IjI0IiByPSIyNCI+PC9jaXJjbGU+CiAgICAgICAgPGcgaWQ9Imljb24vbXlfb3JkZXJfZm9ybS1jb3B5IiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMS4wMDAwMDAsIDguMDAwMDAwKSIgZmlsbD0iI0ZGQTMzQiI+CiAgICAgICAgICAgIDxwYXRoIGQ9Ik0xMy4wNjQwODE1LDAgQzguMTY4MjU1MDEsMCA0LjE5NTIwMjEsMy45MzE2OTE2OCA0LjE5NTIwMjEsOC43NzY1NTA0NiBDNC4xOTUyMDIxLDEzLjYyMTQwOTIgOC4xNjgyNTUwMSwxNy41NTMxMDA5IDEzLjA2NDA4MTUsMTcuNTUzMTAwOSBDMTcuOTU5OTA4LDE3LjU1MzEwMDkgMjEuOTMyOTYwOSwxMy42MjE0MDkyIDIxLjkzMjk2MDksOC43NzY1NTA0NiBDMjEuOTMyOTYwOSwzLjkzMTY5MTY4IDE3Ljk2ODQ1MjIsMCAxMy4wNjQwODE1LDAgTDEzLjA2NDA4MTUsMCBMMTMuMDY0MDgxNSwwIFogTTAsMjUuNjU0OTQ1MSBMMCwzMiBMMjYsMzIgTDI2LDI1LjY1NDk0NTEgQzI2LDIyLjA0MTY2NzYgMjMuMTU0NzgxNSwxOS4xMzUzMzU3IDE5LjYxNzQ4MjcsMTkuMTM1MzM1NyBMNi4zODI1MTcyNSwxOS4xMzUzMzU3IEMyLjg0NTIxODUzLDE5LjEzNTMzNTcgMCwyMi4wNDE2Njc2IDAsMjUuNjU0OTQ1MSBaIiBpZD0ibXlfcGVyc29uYWxfc2V0dGluZ19pY29uIj48L3BhdGg+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=" alt="店家留言">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if (!empty($data['rating_url']))
                                    <a class="btn btn-main m-auto w-75" href="{{ $data['rating_url'] }}" role="button">
                                        編輯評價
                                    </a>
                                @endif
                                @if (!empty($data['rating_desc']))
                                    <p class="text-center t-09 pt-1 t-darkgray">{{ $data['rating_desc'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End:main -->
@endsection