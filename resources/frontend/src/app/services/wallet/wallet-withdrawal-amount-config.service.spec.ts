import {TestBed} from "@angular/core/testing";
import {WalletWithdrawalAmountConfigService} from "./wallet-withdrawal-amount-config.service";

describe('WalletWithdrawalAmountConfigService', () => {
  let service: WalletWithdrawalAmountConfigService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WalletWithdrawalAmountConfigService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
