import { TestBed } from '@angular/core/testing';

import { WechatOfficeAccountService } from './wechat-office-account.service';

describe('WechatOfficeAccountService', () => {
  let service: WechatOfficeAccountService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WechatOfficeAccountService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
