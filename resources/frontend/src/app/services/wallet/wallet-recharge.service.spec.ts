import { TestBed } from '@angular/core/testing';

import { WalletRechargeService } from './wallet-recharge.service';

describe('WalletRechargeService', () => {
  let service: WalletRechargeService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WalletRechargeService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
