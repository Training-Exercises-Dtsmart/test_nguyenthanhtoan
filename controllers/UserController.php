<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\User;
use app\models\LeaveRequest;
use yii\web\UnauthorizedHttpException;

class UserController extends Controller
{
    public function actionIndex()
    {
        return 1;
    }
    public function actionCreateLeaveRequest()
    {
        $accessToken = Yii::$app->request->headers->get('Authorization');
        $user = User::findOne(['access_token' => $accessToken]);

        if (!$user) {
            throw new UnauthorizedHttpException('Invalid access token');
        }

        $leaveRequest = new LeaveRequest();
        $leaveRequest->load(Yii::$app->request->post(), '');
        $leaveRequest->user_id = $user->id;

        if ($leaveRequest->save()) {
            return [
                'status' => true,
                'data' => $leaveRequest,
                'message' => 'Leave request created successfully',
                'code' => 201
            ];
        } else {
            return [
                'status' => false,
                'data' => $leaveRequest->getErrors(),
                'message' => 'Validation errors',
                'code' => 422
            ];
        }
    }

    public function actionViewOwnRequests()
    {

        $accessToken = Yii::$app->request->headers->get('Authorization');
        $user = User::findOne(['access_token' => $accessToken]);

        if (!$user) {
            throw new UnauthorizedHttpException('Invalid access token');
        }

        $leaveRequests = LeaveRequest::findAll(['user_id' => Yii::$app->user->id]);
        return [
            'status' => true,
            'data' => $leaveRequests,
            'message' => 'Leave requests retrieved successfully',
            'code' => 200
        ];
    }
}
