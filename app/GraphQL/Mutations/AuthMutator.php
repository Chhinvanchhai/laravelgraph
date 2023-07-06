<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AuthMutator
{
    public function resolve($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $credentials = Arr::only($args, ['email', 'password']);

        if (Auth::once($credentials)) {

            $user = auth()->user();
            $token = $user->createToken($user->email)->plainTextToken;
            $user = $user;
            // $user->api_token = $token;
            $user->save();

            // return  response()->json([
            //     "token" => $token,
            //     "user" => $user,
            // ], 200);
            return $token;
        }

        return [];
   }
}
