<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationException;
use App\Http\Controllers\traits\ResponseTrait;
use App\Http\Requests\NewMessageRequest;
use App\Mail\SendEmail;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class ApiController extends Controller
{
    use ResponseTrait;

    /**
     * @param NewMessageRequest $request
     * @return JsonResponse
     */
    public function createNewMessage(NewMessageRequest $request)
    {
        try {
            if (Message::where('ip', $ip = $request->ip())->count() >= config('app.max_messages_count', 10)) {
                throw new ValidationException([], t('Sorry, you cannot send messages any more.'));
            }

            /** @var Message $message */
            $message = Message::create([
                'message' => $request->post('message'),
                'ip' => $ip
            ]);

            Mail::to('fixed_address@gmail.com')->queue(new SendEmail($message->message));

            return $this->letterSent();
        } catch (Throwable $e) {
            return self::handleException($e);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     */
    public function resetMyIp(Request $request)
    {
        try {
            Message::where('ip', $request->ip())->delete();
            return 'ok';
        } catch (Throwable $e) {
            return self::handleException($e);
        }
    }

    /**
     * Generate api documentation
     *
     * @return string
     */
    public function genDocs()
    {
        try {
            $config = include base_path('app/Swagger/config/l5-swagger.php');
            $file_name = Str::finish($config['defaults']['paths']['docs'], '/')
                . $config['documentations']['default']['paths']['docs_json'];
            $arr = array_merge($config['api-docs']['main'], [
                'paths' => $config['api-docs']['paths']
            ]);
            file_put_contents($file_name, json_encode($arr));
            return 'ok';
        } catch (\Throwable $e) {
            return self::handleException($e);
        }
    }
}
