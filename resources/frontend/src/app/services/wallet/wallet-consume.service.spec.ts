import { TestBed } from '@angular/core/testing';

import { WalletConsumeService } from './wallet-consume.service';

describe('WalletConsumeService', () => {
  let service: WalletConsumeService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(WalletConsumeService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
