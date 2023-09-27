import {WechatMiniProgramAccount, WechatOfficeAccount} from './wechat';

describe('WechatOfficeAccount', () => {
  it('should create an instance', () => {
    expect(new WechatOfficeAccount()).toBeTruthy();
  });
});

describe('WechatMiniProgramAccount', () => {
  it('should create an instance', () => {
    expect(new WechatMiniProgramAccount()).toBeTruthy();
  });
});
