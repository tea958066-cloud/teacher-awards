<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Excellence Awards — Results</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; color: #222; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #1a237e; padding-bottom: 16px; margin-bottom: 24px; }
        .header h1 { color: #1a237e; font-size: 22px; margin: 0 0 4px; }
        .header p { color: #666; font-size: 13px; margin: 0; }
        .stats-row { display: flex; gap: 20px; margin-bottom: 24px; }
        .stat-box { flex: 1; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px; text-align: center; }
        .stat-box .num { font-size: 24px; font-weight: 700; color: #1a237e; }
        .stat-box .lbl { font-size: 12px; color: #888; }
        .category { margin-bottom: 28px; page-break-inside: avoid; }
        .cat-title { background: #1a237e; color: #fff; padding: 10px 16px; border-radius: 8px 8px 0 0; font-weight: 700; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f5f5f5; font-size: 12px; color: #666; text-transform: uppercase; padding: 8px 12px; text-align: left; }
        td { padding: 9px 12px; border-bottom: 1px solid #eee; font-size: 13px; }
        .winner-row td { background: #fffde7; font-weight: 600; }
        .rank { width: 24px; height: 24px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; }
        .r1 { background: #ffd700; color: #1a237e; }
        .r2 { background: #e0e0e0; color: #424242; }
        .r3 { background: #ffcc80; color: #e65100; }
        .rn { background: #f5f5f5; color: #757575; }
        .bar-bg { background: #e8eaf6; border-radius: 4px; height: 8px; width: 120px; display: inline-block; vertical-align: middle; }
        .bar-fill { background: #1a237e; border-radius: 4px; height: 8px; display: block; }
        .winner-tag { background: #ffd700; color: #1a237e; border-radius: 4px; font-size: 10px; padding: 1px 6px; font-weight: 700; }
        .footer { text-align: center; color: #aaa; font-size: 11px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 12px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
<div class="no-print" style="text-align:right;margin-bottom:16px">
    <button onclick="window.print()" style="background:#1a237e;color:#fff;border:none;padding:10px 24px;border-radius:8px;cursor:pointer;font-size:14px">
        🖨 Print / Save as PDF
    </button>
    <button onclick="window.close()" style="background:#eee;color:#333;border:none;padding:10px 20px;border-radius:8px;cursor:pointer;font-size:14px;margin-left:8px">
        ✕ Close
    </button>
</div>

<div class="header">
    <h1>🏆 Teacher Excellence Awards — Official Results</h1>
    <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
</div>

<div class="stats-row">
    <div class="stat-box">
        <div class="num">{{ $stats['total'] }}</div>
        <div class="lbl">Total Teachers</div>
    </div>
    <div class="stat-box">
        <div class="num">{{ $stats['voted'] }}</div>
        <div class="lbl">Votes Submitted</div>
    </div>
    <div class="stat-box">
        <div class="num">{{ $stats['not_voted'] }}</div>
        <div class="lbl">Did Not Vote</div>
    </div>
    <div class="stat-box">
        <div class="num">{{ $stats['total'] > 0 ? round(($stats['voted']/$stats['total'])*100,1) : 0 }}%</div>
        <div class="lbl">Participation</div>
    </div>
</div>

@foreach($categoryResults as $result)
<div class="category">
    <div class="cat-title">{{ $result['category']->name }}</div>
    @if($result['results']->isEmpty())
    <table><tr><td style="color:#aaa;text-align:center;padding:16px">No votes recorded</td></tr></table>
    @else
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Teacher</th>
                <th>Votes</th>
                <th>Share</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($result['results'] as $idx => $row)
            @php
                $rank = $idx + 1;
                $pct = $result['totalVotes'] > 0 ? round(($row->total / $result['totalVotes']) * 100, 1) : 0;
                $rankClass = $rank === 1 ? 'r1' : ($rank === 2 ? 'r2' : ($rank === 3 ? 'r3' : 'rn'));
            @endphp
            <tr class="{{ $rank === 1 ? 'winner-row' : '' }}">
                <td><span class="rank {{ $rankClass }}">{{ $rank }}</span></td>
                <td>
                    {{ $row->nominee->name ?? 'Unknown' }}
                    @if($rank === 1 && $row->total > 0) <span class="winner-tag">★ Winner</span> @endif
                </td>
                <td>{{ $row->total }}</td>
                <td>
                    <span class="bar-bg"><span class="bar-fill" style="width:{{ $pct }}%"></span></span>
                </td>
                <td>{{ $pct }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endforeach

<div class="footer">Teacher Excellence Awards Voting System &mdash; Confidential Results</div>
</body>
</html>
