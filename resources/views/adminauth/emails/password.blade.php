点击链接重置密码: <a href="{{ $link = url('/zcjy/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
