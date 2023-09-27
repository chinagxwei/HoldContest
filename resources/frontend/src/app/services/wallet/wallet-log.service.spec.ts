import { TestBed } from '@angular/core/testing';

import { WalletLogService } from './wallet-log.service';

describe('WalletLogService', () => {
  let service: WalletLogService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WalletLogService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
