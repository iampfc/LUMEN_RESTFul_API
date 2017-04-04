<?php
$customConfig = new stdClass();
$customConfig->errors = new stdClass();
//通用错误 4xx
$customConfig->errors->permissionFail    = array('message'=>'您没有操作 %s/%s 的权限','code' => 401);
$customConfig->errors->frequently        = array('message'=>'操作频繁，请稍后再试','code'=>402);
$customConfig->errors->vaildFail         = array('message'=>'表单验证不通过','code'=>403);
$customConfig->errors->notFound          = array('message'=>'未找到该资源','code'=>404);
$customConfig->errors->tokenFail         = array('message'=>'登录超时，请重新登录','code'=>405);
$customConfig->errors->uploadToAgFail    = array('message'=>'发生文件到ag失败','code'=>406);
$customConfig->errors->tokenCheckFail    = array('message'=>'Token验证不通过','code'=>407);
$customConfig->errors->smsCheckFail      = array('message'=>'短信验证不通过','code'=>408);

//insert update delete faile 6xx
$customConfig->errors->createFail = array('message'=>'创建失败','code'=>6001);
$customConfig->errors->updateFail = array('message'=>'更新失败','code'=>6002);
$customConfig->errors->deleteFail = array('message'=>'删除失败','code'=>6003);
$customConfig->errors->submitFail = array('message'=>'提交失败','code'=>6004);
$customConfig->errors->valueFail  = array('message'=>'必填参数不能为空','code'=>6005);

//其他错误 7xxx
$customConfig->errors->getTokenFail   = array('message' => '请传入token进行验证身份','code' => 7001);
$customConfig->errors->loginFail = array('message'=>'用户名或者密码错误','code'=>7002);
$customConfig->errors->createExist = array('message'=>'此用户已经存在','code'=>7003);
$customConfig->errors->registerFail = array('message'=>'注册失败','code'=>7004);
$customConfig->errors->awardTokenFail = array('message'=>'token颁发失败','code'=>7005);
$customConfig->errors->noRegister = array('message'=>'该用户不存在,请检查用户名是否正确','code'=>7006);
$customConfig->errors->disable = array('message'=>'此用户已经被禁用','code'=>7007);
$customConfig->errors->passwordrule = array('message'=>'密码应该符合规则，长度至少为六位','code'=>7008);
$customConfig->errors->oldPasswordFail = array('message'=>'旧密码错误','code'=>7009);
$customConfig->errors->changePasswordFail = array('message'=>'修改密码失败','code'=>7010);
$customConfig->errors->disableError = array('message'=>'停用用户失败','code'=>7011);
$customConfig->errors->activateError = array('message'=>'解禁用户失败','code'=>7012);
$customConfig->errors->notFoundUser = array('message'=>'公司名称或者用户名错误','code'=>7013);
$customConfig->errors->notFoundAdmin = array('message'=>'该运维人员账号不存在,请核对后重新输入','code'=>7014);
$customConfig->errors->mobileExist = array('message'=>'同个公司一个手机号只能注册一个账号','code'=>7015);
$customConfig->errors->passwordNoPass = array('message'=>'两次密码不一致','code'=>7016);
$customConfig->errors->groupNotSaved = array('message'=>'没有保存，请确认选择了权限数据','code'=>7017);
$customConfig->errors->groupNoExist = array('message'=>'该分组不存在','code'=>7018);
$customConfig->errors->smsFail = array('message'=>'短信发送失败','code'=>7018);
$customConfig->errors->mobileExist = array('message'=>'该手机号码已经注册','code'=>7019);

?>