import { TestBed } from '@angular/core/testing';

import { LuckyDrawsConfigService } from './lucky-draws-config.service';

describe('LuckyDrawsConfigService', () => {
  let service: LuckyDrawsConfigService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(LuckyDrawsConfigService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
