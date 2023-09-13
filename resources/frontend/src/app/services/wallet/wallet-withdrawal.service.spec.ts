import { TestBed } from '@angular/core/testing';

import { WalletWithdrawalService } from './wallet-withdrawal.service';

describe('WalletWithdrawalService', () => {
  let service: WalletWithdrawalService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WalletWithdrawalService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
