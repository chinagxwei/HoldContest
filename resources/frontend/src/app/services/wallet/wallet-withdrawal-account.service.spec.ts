import { TestBed } from '@angular/core/testing';

import { WalletWithdrawalAccountService } from './wallet-withdrawal-account.service';

describe('WalletWithdrawalAccountService', () => {
  let service: WalletWithdrawalAccountService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WalletWithdrawalAccountService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
