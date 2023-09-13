import { TestBed } from '@angular/core/testing';

import { WechatMiniProgramAccountService } from './wechat-mini-program-account.service';

describe('WechatMiniProgramAccountService', () => {
  let service: WechatMiniProgramAccountService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WechatMiniProgramAccountService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
