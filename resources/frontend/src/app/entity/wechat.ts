export class WechatOfficeAccount {
  id?: number;
  member_id: string = "";
  openid: string = "";
  unionid: string = "";
  nickname: string = "";
  sex: number = 0;
  city: string = "";
  province: string = "";
  country: string = "";
  headimgurl: string = "";
  subscribe: number = 0;
  subscribe_at: number = 0;
  unsubscribe_at: number = 0;
  created_at?: number;
}

export class WechatMiniProgramAccount {
  id?: number;
  member_id: string = "";
  openid: string = "";
  unionid: string = "";
  nickname: string = "";
  sex: number = 0;
  city: string = "";
  province: string = "";
  country: string = "";
  headimgurl: string = "";
  created_at: number = 0;
}
