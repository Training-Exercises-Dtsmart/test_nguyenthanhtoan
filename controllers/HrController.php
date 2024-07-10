<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\User;
use app\models\LeaveRequest;

class HrController extends Controller
{
    public function actionCreateStaff()
    {
        $user = new User();
        $user->load(Yii::$app->request->post(), '');
        $user->role = 'staff';
        $user->setPassword(Yii::$app->request->post('password'));
        $user->generateAccessToken();

        if ($user->save()) {
            return [
                'status' => true,
                'data' => $user,
                'message' => 'Staff created successfully',
                'code' => 201
            ];
        } else {
            return [
                'status' => false,
                'data' => $user->getErrors(),
                'message' => 'Validation errors',
                'code' => 422
            ];
        }
    }

    public function actionViewAllRequests()
    {
        $leaveRequests = LeaveRequest::find()->all();
        return [
            'status' => true,
            'data' => $leaveRequests,
            'message' => 'Leave requests retrieved successfully',
            'code' => 200
        ];
    }

    public function actionApproveRequest($id)
    {
        $leaveRequest = LeaveRequest::findOne($id);
        if (!$leaveRequest) {
            return [
                'status' => false,
                'data' => null,
                'message' => 'Leave request not found',
                'code' => 404
            ];
        }

        $leaveRequest->status = 'approved';
        if ($leaveRequest->save()) {
            return [
                'status' => true,
                'data' => $leaveRequest,
                'message' => 'Leave request approved',
                'code' => 200
            ];
        } else {
            return [
                'status' => false,
                'data' => $leaveRequest->getErrors(),
                'message' => 'Failed to approve leave request',
                'code' => 500
            ];
        }
    }

    public function actionDisapproveRequest($id)
    {
        $leaveRequest = LeaveRequest::findOne($id);
        if (!$leaveRequest) {
            return [
                'status' => false,
                'data' => null,
                'message' => 'Leave request not found',
                'code' => 404
            ];
        }

        $leaveRequest->status = 'disapproved';
        if ($leaveRequest->save()) {
            return [
                'status' => true,
                'data' => $leaveRequest,
                'message' => 'Leave request disapproved',
                'code' => 200
            ];
        } else {
            return [
                'status' => false,
                'data' => $leaveRequest->getErrors(),
                'message' => 'Failed to disapprove leave request',
                'code' => 500
            ];
        }
    }
}
